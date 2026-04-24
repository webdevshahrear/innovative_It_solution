<?php

namespace App\Http\Controllers\Admin\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipExamQuestion;
use App\Models\InternshipCategory;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(protected GeminiService $gemini) {}

    public function index(Request $request)
    {
        $query = InternshipExamQuestion::with('category')->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('approved')) {
            $query->where('is_approved', $request->approved == '1');
        }
        if ($request->filled('source')) {
            $query->where('generated_by', $request->source);
        }

        $questions  = $query->paginate(20)->withQueryString();
        $categories = InternshipCategory::orderBy('name')->get();

        return view('admin.internship.questions.index', compact('questions', 'categories'));
    }

    public function create()
    {
        $categories = InternshipCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.internship.questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:internship_categories,id',
            'question_text'  => 'required|string',
            'option_a'       => 'required|string|max:300',
            'option_b'       => 'required|string|max:300',
            'option_c'       => 'required|string|max:300',
            'option_d'       => 'required|string|max:300',
            'correct_option' => 'required|in:a,b,c,d',
            'explanation'    => 'nullable|string',
            'difficulty'     => 'required|in:easy,medium,hard',
            'is_approved'    => 'boolean',
        ]);

        $validated['generated_by'] = 'manual';
        $validated['is_approved']  = $request->boolean('is_approved');

        InternshipExamQuestion::create($validated);

        return redirect()->route('admin.internship.questions.index')
            ->with('success', 'Question added successfully.');
    }

    public function edit(InternshipExamQuestion $question)
    {
        $categories = InternshipCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.internship.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, InternshipExamQuestion $question)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:internship_categories,id',
            'question_text'  => 'required|string',
            'option_a'       => 'required|string|max:300',
            'option_b'       => 'required|string|max:300',
            'option_c'       => 'required|string|max:300',
            'option_d'       => 'required|string|max:300',
            'correct_option' => 'required|in:a,b,c,d',
            'explanation'    => 'nullable|string',
            'difficulty'     => 'required|in:easy,medium,hard',
            'is_approved'    => 'boolean',
        ]);

        $validated['is_approved'] = $request->boolean('is_approved');
        $question->update($validated);

        return redirect()->route('admin.internship.questions.index')
            ->with('success', 'Question updated.');
    }

    public function destroy(InternshipExamQuestion $question)
    {
        $question->delete();
        return back()->with('success', 'Question deleted.');
    }

    public function approve(InternshipExamQuestion $question)
    {
        $question->update(['is_approved' => !$question->is_approved]);
        $msg = $question->is_approved ? 'Question approved.' : 'Question unapproved.';
        return back()->with('success', $msg);
    }

    // ── AI Generation Page ──
    public function generatePage()
    {
        $categories = InternshipCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.internship.questions.generate', compact('categories'));
    }

    // ── AI Generate API (AJAX) ──
    public function generateAI(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:internship_categories,id',
            'difficulty'  => 'required|in:easy,medium,hard',
            'count'       => 'required|integer|min:5|max:30',
        ]);

        $category   = InternshipCategory::findOrFail($request->category_id);
        $questions  = $this->gemini->generateQuestions(
            $category->name,
            $request->difficulty,
            (int) $request->count
        );

        if (isset($questions['error'])) {
            return response()->json(['error' => $questions['error']], 422);
        }

        // Bulk insert as unapproved
        $inserted = 0;
        foreach ($questions as $q) {
            InternshipExamQuestion::create([
                'category_id'    => $request->category_id,
                'question_text'  => $q['question'],
                'option_a'       => $q['option_a'],
                'option_b'       => $q['option_b'],
                'option_c'       => $q['option_c'],
                'option_d'       => $q['option_d'],
                'correct_option' => $q['correct'],
                'explanation'    => $q['explanation'],
                'difficulty'     => $request->difficulty,
                'is_approved'    => false,
                'generated_by'   => 'gemini',
            ]);
            $inserted++;
        }

        return response()->json([
            'success' => true,
            'count'   => $inserted,
            'message' => "{$inserted} questions generated. Review and approve them in the question bank.",
        ]);
    }
}
