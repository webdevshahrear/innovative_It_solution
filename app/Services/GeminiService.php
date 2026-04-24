<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model  = config('services.gemini.model', 'gemini-2.5-flash');
    }

    /**
     * Generate MCQ questions for a given category.
     */
    public function generateQuestions(string $category, string $difficulty = 'medium', int $count = 10): array
    {
        $prompt = $this->buildPrompt($category, $difficulty, $count);

        try {
            $response = Http::timeout(60)->post(
                "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.7,
                        'maxOutputTokens' => 8192,
                    ]
                ]
            );

            if ($response->failed()) {
                Log::error('Gemini API error', ['status' => $response->status(), 'body' => $response->body()]);
                return ['error' => 'Gemini API request failed. Status: ' . $response->status()];
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

            return $this->parseQuestions($text);

        } catch (\Exception $e) {
            Log::error('Gemini exception', ['message' => $e->getMessage()]);
            return ['error' => 'Failed to connect to Gemini API: ' . $e->getMessage()];
        }
    }

    protected function buildPrompt(string $category, string $difficulty, int $count): string
    {
        return <<<PROMPT
You are an expert IT trainer creating exam questions for an internship program at a digital agency in Bangladesh.

Generate exactly {$count} multiple-choice questions for the category: "{$category}"
Difficulty level: {$difficulty}

Rules:
- Questions must be practical and relevant to real-world IT work
- Cover key concepts, tools, and best practices for this category
- Make sure only ONE answer is correct
- Options should be plausible and not obviously wrong
- Write in clear, professional English

IMPORTANT: Return ONLY a valid JSON array. No explanation, no markdown, no code blocks. Just the raw JSON array.

Required JSON format:
[
  {
    "question": "What does CSS stand for?",
    "options": {
      "a": "Cascading Style Sheets",
      "b": "Creative Style System",
      "c": "Computer Style Sheets",
      "d": "Colorful Style Syntax"
    },
    "correct": "a",
    "explanation": "CSS stands for Cascading Style Sheets, which is used to style HTML documents."
  }
]

Generate {$count} questions now:
PROMPT;
    }

    protected function parseQuestions(string $text): array
    {
        // Strip markdown code fences if present
        $text = preg_replace('/```json\s*|\s*```/', '', $text);
        $text = trim($text);

        // Find JSON array boundaries
        $start = strpos($text, '[');
        $end   = strrpos($text, ']');

        if ($start === false || $end === false) {
            Log::warning('Gemini: No JSON array found in response', ['text' => $text]);
            return ['error' => 'Could not parse questions from AI response. Please try again.'];
        }

        $json = substr($text, $start, $end - $start + 1);

        $questions = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('Gemini: JSON parse error', ['error' => json_last_error_msg(), 'text' => $json]);
            return ['error' => 'AI response was not valid JSON. Please try again.'];
        }

        if (!is_array($questions) || empty($questions)) {
            return ['error' => 'No questions were generated. Please try again.'];
        }

        // Validate each question structure
        $validated = [];
        foreach ($questions as $q) {
            if (
                isset($q['question'], $q['options']['a'], $q['options']['b'],
                    $q['options']['c'], $q['options']['d'], $q['correct'])
            ) {
                $validated[] = [
                    'question'    => $q['question'],
                    'option_a'    => $q['options']['a'],
                    'option_b'    => $q['options']['b'],
                    'option_c'    => $q['options']['c'],
                    'option_d'    => $q['options']['d'],
                    'correct'     => strtolower($q['correct']),
                    'explanation' => $q['explanation'] ?? '',
                ];
            }
        }

        return $validated;
    }
}
