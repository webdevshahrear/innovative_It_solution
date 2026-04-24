<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\InternshipNotice;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $account = $user->internAccount()->with(['category', 'mentor', 'application'])->firstOrFail();

        $tasks = $account->tasks()->with('submission')->latest()->get();

        $stats = [
            'pending'   => $account->pendingTasks()->count(),
            'submitted' => $account->submittedTasks()->count(),
            'approved'  => $account->approvedTasks()->count(),
            'total'     => $tasks->count(),
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

        // Certificate eligibility
        $certEligible = $account->performance_score >= 60
            && $stats['approved'] >= 5
            && $account->status === 'active';

        return view('intern.dashboard', compact(
            'user', 'account', 'stats', 'notices', 'recentTasks', 'certEligible'
        ));
    }
}
