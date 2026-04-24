<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\InternshipAccount;
use App\Models\InternshipTask;

class DashboardController extends Controller
{
    public function index()
    {
        $mentor  = auth()->user();
        $interns = InternshipAccount::where('mentor_id', $mentor->id)
            ->where('status', 'active')
            ->with(['user', 'category', 'application'])
            ->get();

        $pendingReviews = InternshipTask::whereIn('intern_account_id', $interns->pluck('id'))
            ->where('status', 'submitted')
            ->with(['internAccount.user', 'submission'])
            ->latest()
            ->limit(10)
            ->get();

        $stats = [
            'total_interns'    => $interns->count(),
            'pending_reviews'  => $pendingReviews->count(),
            'tasks_assigned'   => InternshipTask::whereIn('intern_account_id', $interns->pluck('id'))->count(),
            'tasks_approved'   => InternshipTask::whereIn('intern_account_id', $interns->pluck('id'))->where('status', 'approved')->count(),
        ];

        return view('mentor.dashboard', compact('mentor', 'interns', 'pendingReviews', 'stats'));
    }
}
