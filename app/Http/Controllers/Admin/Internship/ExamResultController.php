<?php

namespace App\Http\Controllers\Admin\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipExamAttempt;
use App\Models\InternshipCategory;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function index(Request $request)
    {
        $query = InternshipExamAttempt::with(['application', 'category', 'tabViolations'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $results    = $query->paginate(20)->withQueryString();
        $categories = InternshipCategory::orderBy('name')->get();

        $stats = [
            'total'      => InternshipExamAttempt::count(),
            'passed'     => InternshipExamAttempt::where('status', 'passed')->count(),
            'failed'     => InternshipExamAttempt::where('status', 'failed')->count(),
            'terminated' => InternshipExamAttempt::where('status', 'terminated')->count(),
        ];

        return view('admin.internship.exam-results.index', compact('results', 'categories', 'stats'));
    }
}
