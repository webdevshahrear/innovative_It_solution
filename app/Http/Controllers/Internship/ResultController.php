<?php

namespace App\Http\Controllers\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipExamAttempt;
use App\Models\InternshipExamAnswer;
use App\Models\InternshipExamQuestion;

class ResultController extends Controller
{
    public function show(InternshipExamAttempt $attempt)
    {
        // Don't show result for in-progress exams
        if ($attempt->isInProgress()) {
            return redirect()->route('internship.exam', $attempt);
        }

        $attempt->load('application', 'category');

        // Load answered questions with correct answers for review
        $answers = InternshipExamAnswer::where('attempt_id', $attempt->id)
            ->with('question')
            ->get();

        $passMark = (int) env('INTERNSHIP_PASS_MARK', 60);

        return view('internship.result', compact('attempt', 'answers', 'passMark'));
    }
}
