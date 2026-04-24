<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\InternshipAccount;
use App\Models\InternshipTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $mentor   = auth()->user();
        $internIds = InternshipAccount::where('mentor_id', $mentor->id)->pluck('id');
        $tasks    = InternshipTask::whereIn('intern_account_id', $internIds)
            ->with(['internAccount.user', 'submission'])
            ->latest()
            ->paginate(15);

        return view('mentor.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $mentor  = auth()->user();
        $interns = InternshipAccount::where('mentor_id', $mentor->id)
            ->where('status', 'active')
            ->with('user')
            ->get();

        return view('mentor.tasks.create', compact('interns'));
    }

    public function store(Request $request)
    {
        $mentor = auth()->user();

        $request->validate([
            'intern_account_id' => 'required|exists:internship_accounts,id',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'deadline'          => 'required|date|after:now',
            'priority'          => 'required|in:low,medium,high,urgent',
            'resources'         => 'nullable|string',
        ]);

        // Verify this intern belongs to this mentor
        $account = InternshipAccount::where('id', $request->intern_account_id)
            ->where('mentor_id', $mentor->id)
            ->firstOrFail();

        InternshipTask::create([
            'intern_account_id' => $account->id,
            'assigned_by'       => $mentor->id,
            'title'             => $request->title,
            'description'       => $request->description,
            'deadline'          => $request->deadline,
            'priority'          => $request->priority,
            'resources'         => $request->resources,
            'status'            => 'pending',
        ]);

        return redirect()->route('mentor.tasks.index')
            ->with('success', 'Task assigned successfully!');
    }

    public function review(Request $request, InternshipTask $task)
    {
        $mentor = auth()->user();

        // Verify task belongs to this mentor's interns
        $account = InternshipAccount::where('id', $task->intern_account_id)
            ->where('mentor_id', $mentor->id)
            ->firstOrFail();

        $request->validate([
            'status'          => 'required|in:approved,rejected',
            'mentor_feedback' => 'required|string|min:10',
            'score'           => 'required|numeric|min:0|max:100',
        ]);

        $task->update([
            'status'          => $request->status,
            'mentor_feedback' => $request->mentor_feedback,
            'score'           => $request->score,
        ]);

        // Recalculate intern performance score
        if ($request->status === 'approved') {
            $avgScore = InternshipTask::where('intern_account_id', $account->id)
                ->where('status', 'approved')
                ->whereNotNull('score')
                ->avg('score');

            $account->update(['performance_score' => round($avgScore ?? 0, 2)]);
        }

        return back()->with('success', 'Task reviewed successfully!');
    }

    public function show(InternshipTask $task)
    {
        $task->load('internAccount.user', 'submission', 'assignedBy');
        return view('mentor.tasks.show', compact('task'));
    }
}
