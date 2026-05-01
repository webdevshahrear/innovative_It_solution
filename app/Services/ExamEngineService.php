<?php

namespace App\Services;

use App\Models\InternshipExamAttempt;
use App\Models\InternshipExamAnswer;
use App\Models\InternshipExamQuestion;
use App\Models\InternshipApplication;
use App\Models\InternshipTabViolation;

class ExamEngineService
{
    protected int $questionCount = 20;
    protected int $passMark;

    public function __construct()
    {
        $setting = \App\Models\SiteSetting::where('setting_key', 'internship_pass_mark')->value('setting_value');
        $this->passMark = $setting ? (int) $setting : 60;
    }

    /**
     * Create a new exam attempt for an application.
     */
    public function createAttempt(InternshipApplication $application): InternshipExamAttempt
    {
        // Invalidate any previous in-progress attempts
        InternshipExamAttempt::where('application_id', $application->id)
            ->where('status', 'in_progress')
            ->update(['status' => 'terminated', 'terminated_at' => now()]);

        $questions = $this->getRandomQuestions($application->preferred_category_id);

        $attempt = InternshipExamAttempt::create([
            'application_id'  => $application->id,
            'category_id'     => $application->preferred_category_id,
            'session_token'   => InternshipExamAttempt::generateSessionToken(),
            'ip_address'      => request()->ip(),
            'started_at'      => now(),
            'total_questions' => $questions->count(),
            'status'          => 'in_progress',
        ]);

        // Pre-create answer slots
        foreach ($questions as $question) {
            InternshipExamAnswer::create([
                'attempt_id'  => $attempt->id,
                'question_id' => $question->id,
                'is_correct'  => false,
            ]);
        }

        return $attempt;
    }

    /**
     * Get randomized approved questions for a category.
     */
    public function getRandomQuestions(int $categoryId)
    {
        $questions = InternshipExamQuestion::approved()
            ->forCategory($categoryId)
            ->inRandomOrder()
            ->limit($this->questionCount)
            ->get();

        return $questions;
    }

    /**
     * Submit the exam and calculate result.
     */
    public function submitAttempt(InternshipExamAttempt $attempt, array $answers): array
    {
        if (!$attempt->isInProgress()) {
            return ['error' => 'This exam attempt is no longer active.'];
        }

        $correctCount = 0;
        $totalCount   = 0;

        foreach ($answers as $questionId => $selectedOption) {
            $question = InternshipExamQuestion::find($questionId);
            if (!$question) continue;

            $isCorrect = strtolower($selectedOption) === strtolower($question->correct_option);
            if ($isCorrect) $correctCount++;
            $totalCount++;

            InternshipExamAnswer::where('attempt_id', $attempt->id)
                ->where('question_id', $questionId)
                ->update([
                    'selected_option' => strtolower($selectedOption),
                    'is_correct'      => $isCorrect,
                ]);
        }

        $total      = $attempt->total_questions;
        $percentage = $total > 0 ? round(($correctCount / $total) * 100, 2) : 0;
        $passed     = $percentage >= $this->passMark;

        $attempt->update([
            'correct_answers'  => $correctCount,
            'score_percentage' => $percentage,
            'status'           => $passed ? 'passed' : 'failed',
            'submitted_at'     => now(),
            'session_token'    => null, // Invalidate session
        ]);

        // Update application status
        $attempt->application->update([
            'status' => $passed ? 'exam_passed' : 'exam_failed',
        ]);

        return [
            'passed'        => $passed,
            'correct'       => $correctCount,
            'wrong'         => $total - $correctCount,
            'total'         => $total,
            'percentage'    => $percentage,
            'pass_mark'     => $this->passMark,
        ];
    }

    /**
     * Terminate an exam due to tab switch / cheating.
     */
    public function terminateAttempt(InternshipExamAttempt $attempt, string $reason): void
    {
        if (!$attempt->isInProgress()) return;

        $attempt->update([
            'status'        => 'terminated',
            'terminated_at' => now(),
            'session_token' => null,
        ]);

        InternshipTabViolation::create([
            'attempt_id'    => $attempt->id,
            'violation_type' => $reason,
            'occurred_at'   => now(),
        ]);

        $attempt->increment('tab_switch_count');

        $attempt->application->update(['status' => 'exam_failed']);
    }

    /**
     * Validate that the session token matches (anti-replay).
     */
    public function validateSession(InternshipExamAttempt $attempt, string $token): bool
    {
        return $attempt->session_token === $token && $attempt->isInProgress();
    }
}
