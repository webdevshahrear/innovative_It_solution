<?php

namespace App\Http\Controllers\Admin\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipAccount;
use App\Models\User;
use Illuminate\Http\Request;

class InternManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = InternshipAccount::with(['user', 'category', 'mentor', 'application'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $accounts = $query->paginate(20)->withQueryString();
        $mentors  = User::where('role', 'mentor')->orderBy('name')->get();

        return view('admin.internship.interns.index', compact('accounts', 'mentors'));
    }

    public function show(InternshipAccount $account)
    {
        $account->load(['user', 'category', 'mentor', 'application', 'tasks.submission', 'certificate']);
        $mentors = User::where('role', 'mentor')->orderBy('name')->get();

        return view('admin.internship.interns.show', compact('account', 'mentors'));
    }

    public function assignMentor(Request $request, InternshipAccount $account)
    {
        $request->validate([
            'mentor_id' => 'required|exists:users,id',
        ]);

        $mentor = User::findOrFail($request->mentor_id);
        if ($mentor->role !== 'mentor' && $mentor->role !== 'admin') {
            return back()->with('error', 'Selected user is not a mentor.');
        }

        $account->update(['mentor_id' => $request->mentor_id]);
        return back()->with('success', 'Mentor assigned successfully.');
    }

    public function toggleStatus(Request $request, InternshipAccount $account)
    {
        $newStatus = $account->status === 'active' ? 'suspended' : 'active';
        $account->update(['status' => $newStatus]);
        return back()->with('success', "Intern account {$newStatus}.");
    }
}
