<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\InternshipTask;
use App\Models\InternshipTaskSubmission;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $account = auth()->user()->internAccount;
        $tasks   = $account->tasks()->with('submission')->latest()->paginate(10);

        return view('intern.tasks.index', compact('tasks', 'account'));
    }

    public function show(InternshipTask $task)
    {
        $account = auth()->user()->internAccount;

        // Ensure task belongs to this intern
        if ($task->intern_account_id !== $account->id) {
            abort(403);
        }

        $task->load('submission', 'assignedBy');

        return view('intern.tasks.show', compact('task', 'account'));
    }

    public function submit(Request $request, InternshipTask $task)
    {
        $account = auth()->user()->internAccount;

        if ($task->intern_account_id !== $account->id) abort(403);
        if (in_array($task->status, ['submitted', 'approved'])) {
            return back()->with('error', 'This task has already been submitted.');
        }

        $request->validate([
            'submission_text' => 'required|string|min:20',
            'live_url'        => 'nullable|url',
            'github_url'      => 'nullable|url',
            'files.*'         => 'nullable|file|max:10240',
        ]);

        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePaths[] = $file->store('task-submissions', 'public');
            }
        }

        InternshipTaskSubmission::updateOrCreate(
            ['task_id' => $task->id],
            [
                'submission_text' => $request->submission_text,
                'live_url'        => $request->live_url,
                'github_url'      => $request->github_url,
                'file_paths'      => $filePaths,
                'submitted_at'    => now(),
            ]
        );

        $task->update(['status' => 'submitted']);

        return back()->with('success', 'Task submitted successfully! Your mentor will review it soon.');
    }
}
