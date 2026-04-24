<?php

namespace App\Http\Controllers\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipExamAttempt;
use App\Models\InternshipExamAnswer;
use App\Models\InternshipExamQuestion;
use App\Services\ExamEngineService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(protected ExamEngineService $examEngine) {}

    /**
     * Show the exam page.
     */
    public function show(Request $request, InternshipExamAttempt $attempt)
    {
        // Security checks
        if ($attempt->status === 'terminated') {
            return view('internship.exam-terminated', compact('attempt'));
        }

        if (!$attempt->isInProgress()) {
            return redirect()->route('internship.result', $attempt);
        }

        // Validate session token
        $storedToken = session("exam_token_{$attempt->id}");
        if (!$storedToken) {
            session(["exam_token_{$attempt->id}" => $attempt->session_token]);
        } elseif ($storedToken !== $attempt->session_token) {
            return redirect()->route('internship.landing')->with('error', 'Invalid exam session.');
        }

        // Load answers and preserve order (assigned during creation)
        $examAnswers = InternshipExamAnswer::where('attempt_id', $attempt->id)
            ->with('question')
            ->orderBy('id')
            ->get();

        // Calculate actual remaining time
        $examDurationMinutes = (int) config('services.internship.exam_duration', 30);
        $elapsedSeconds = now()->diffInSeconds($attempt->started_at);
        $timeRemainingSeconds = max(0, ($examDurationMinutes * 60) - $elapsedSeconds);

        return view('internship.exam', compact('attempt', 'examAnswers', 'timeRemainingSeconds'));
    }

    /**
     * Submit exam answers.
     */
    public function submit(Request $request, InternshipExamAttempt $attempt)
    {
        // If exam already graded (passed/failed), redirect to result
        if (in_array($attempt->status, ['passed', 'failed'])) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success'     => true,
                    'redirect_to' => route('internship.result', $attempt),
                ]);
            }
            return redirect()->route('internship.result', $attempt);
        }

        if (!$attempt->isInProgress()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Exam is no longer active.'], 422);
            }
            return redirect()->route('internship.landing')->with('error', 'This exam session has ended.');
        }

        $answers = $request->input('answers', []);

        $result = $this->examEngine->submitAttempt($attempt, $answers);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 422);
        }

        // Clear session token
        session()->forget("exam_token_{$attempt->id}");

        if ($request->wantsJson()) {
            return response()->json([
                'success'     => true,
                'redirect_to' => route('internship.result', $attempt),
            ]);
        }

        return redirect()->route('internship.result', $attempt);
    }

    /**
     * Terminate exam due to tab switch / anti-cheat.
     */
    public function terminate(Request $request, InternshipExamAttempt $attempt)
    {
        $reason = $request->input('reason', 'tab_switch');

        $allowed = ['tab_switch', 'blur', 'visibility_hidden', 'keyboard_shortcut'];
        if (!in_array($reason, $allowed)) {
            $reason = 'tab_switch';
        }

        $this->examEngine->terminateAttempt($attempt, $reason);

        session()->forget("exam_token_{$attempt->id}");

        return response()->json(['success' => true, 'message' => 'Exam terminated.']);
    }
}
