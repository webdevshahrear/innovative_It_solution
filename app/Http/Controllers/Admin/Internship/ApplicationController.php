<?php

namespace App\Http\Controllers\Admin\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use App\Models\InternshipCategory;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = InternshipApplication::with(['preferredCategory'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('preferred_category_id', $request->category);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->paginate(20)->withQueryString();
        $categories   = InternshipCategory::orderBy('name')->get();

        return view('admin.internship.applications.index', compact('applications', 'categories'));
    }

    public function show(InternshipApplication $application)
    {
        $application->load([
            'preferredCategory', 'secondaryCategory',
            'examAttempts.tabViolations', 'payments', 'account.user',
        ]);

        return view('admin.internship.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, InternshipApplication $application)
    {
        $request->validate([
            'status'      => 'required|in:pending,reviewed,rejected,active',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $application->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Application status updated.');
    }
}
