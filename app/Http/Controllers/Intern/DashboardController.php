<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\InternshipNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $account = $user->internAccount()->with(['category', 'mentor', 'application'])->firstOrFail();

        $tasks = $account->tasks()->with('submission')->latest()->get();

        $daysRemaining = max(0, (int) ceil(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($account->end_date), false)));

        $stats = [
            'pending_tasks'   => $account->pendingTasks()->count(),
            'submitted'       => $account->submittedTasks()->count(),
            'completed_tasks' => $account->approvedTasks()->count(),
            'approved'        => $account->approvedTasks()->count(),
            'total'           => $tasks->count(),
            'days_remaining'  => $daysRemaining,
        ];

        $notices = InternshipNotice::published()
            ->where(function ($q) use ($account) {
                $q->where('target_audience', 'all')
                  ->orWhere('target_category_id', $account->category_id);
            })
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        $recentTasks = $tasks->take(5);

        $certEligible = $account->performance_score >= 60
            && $stats['approved'] >= 5
            && $account->status === 'active';

        return view('intern.dashboard', compact(
            'user', 'account', 'stats', 'notices', 'recentTasks', 'certEligible'
        ));
    }

    public function profile()
    {
        $user    = auth()->user();
        $account = $user->internAccount()->with(['category', 'mentor', 'application'])->firstOrFail();

        return view('intern.profile', compact('user', 'account'));
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'             => 'required|string|max:100',
            'current_password' => 'nullable|string',
            'password'         => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user->name = $request->name;

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();
        
        // Sync with Application
        $account = $user->internAccount()->with('application')->first();
        if ($account && $account->application) {
            $account->application->update([
                'full_name' => $user->name,
                'email'     => $user->email,
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function certification()
    {
        $user    = auth()->user();
        $account = $user->internAccount()->with('category')->firstOrFail();

        $stats = [
            'approved' => $account->approvedTasks()->count(),
        ];

        $certEligible = $account->performance_score >= 60
            && $stats['approved'] >= 5
            && $account->status === 'active';

        return view('intern.certification', compact('user', 'account', 'stats', 'certEligible'));
    }

    public function certificateDownload()
    {
        $user    = auth()->user();
        $account = $user->internAccount()->with('category')->firstOrFail();

        $stats = ['approved' => $account->approvedTasks()->count()];

        $certEligible = $account->performance_score >= 60
            && $stats['approved'] >= 5
            && $account->status === 'active';

        abort_if(!$certEligible, 403, 'You are not eligible for certification yet.');

        $siteLogo = \App\Models\SiteSetting::getValue('site_logo', 'logo.png');

        return view('intern.certificate-print', compact('user', 'account', 'siteLogo'));
    }
}
