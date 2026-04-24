<?php

namespace App\Http\Controllers\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipCategory;
use App\Models\InternshipApplication;
use App\Models\InternshipExamAttempt;
use App\Services\ExamEngineService;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    // ── Landing Page ──
    public function landing()
    {
        $categories = InternshipCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $stats = [
            'applications' => InternshipApplication::count(),
            'active_interns' => \App\Models\InternshipAccount::where('status', 'active')->count(),
            'categories'   => $categories->count(),
        ];

        return view('internship.landing', compact('categories', 'stats'));
    }

    // ── Application Form ──
    public function apply()
    {
        $categories = InternshipCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('internship.apply', compact('categories'));
    }

    // ── Store Application ──
    public function storeApplication(Request $request)
    {
        $validated = $request->validate([
            'full_name'             => 'required|string|max:255',
            'father_name'           => 'required|string|max:255',
            'mother_name'           => 'required|string|max:255',
            'dob'                   => 'required|date|before:today',
            'gender'                => 'required|string|in:Male,Female,Other',
            'blood_group'           => 'required|string|max:10',
            'nid_birth_number'      => 'required|string|max:50',
            'district'              => 'required|string|max:100',
            'phone'                 => 'required|string|max:20',
            'email'                 => 'required|email|max:255|unique:internship_applications,email',
            'address'               => 'required|string|max:500',
            'permanent_address'     => 'required|string|max:500',
            'education'             => 'required|string|max:255',
            'institute_name'        => 'required|string|max:255',
            'passing_year'          => 'required|string|max:50',
            'current_status'        => 'required|string',
            'preferred_category_id' => 'required|exists:internship_categories,id',
            'secondary_category_id' => 'nullable|exists:internship_categories,id',
            'skills'                => 'required|string|max:1000',
            'portfolio_url'         => 'nullable|url|max:255',
            'linkedin_url'          => 'required|url|max:255',
            'cv'                    => 'required|file|mimes:pdf,doc,docx|max:5120',
            'photo'                 => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'motivation'            => 'required|string|max:2000',
            'available_hours'       => 'required|string|max:100',
            'has_laptop'            => 'nullable|boolean',
            'has_internet'          => 'nullable|boolean',
            'emergency_contact_name'         => 'required|string|max:255',
            'emergency_contact_relationship' => 'required|string|max:100',
            'emergency_contact_phone'        => 'required|string|max:20',
        ], [
            'email.unique'  => 'An application with this email already exists.',
            'dob.before'    => 'Date of birth must be a past date.',
            'cv.required'   => 'Please upload your CV to proceed.',
            'photo.required' => 'A professional profile photo is required.',
        ]);

        // Handle CV upload
        if ($request->hasFile('cv')) {
            $validated['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        // Handle Photo upload
        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('intern_photos', 'public');
        }

        $validated['has_laptop']  = (bool) $request->has_laptop;
        $validated['has_internet'] = (bool) $request->has_internet;

        $application = InternshipApplication::create($validated);

        return redirect()->route('internship.terms', $application)
            ->with('success', 'Application submitted! Please read and accept the terms & conditions.');
    }

    // ── Terms Page ──
    public function terms(InternshipApplication $application)
    {
        if ($application->terms_accepted) {
            // Already accepted — redirect to exam if attempt exists
            $attempt = $application->latestAttempt;
            if ($attempt && $attempt->isInProgress()) {
                return redirect()->route('internship.exam', $attempt);
            }
        }

        return view('internship.terms', compact('application'));
    }

    // ── Accept Terms ──
    public function acceptTerms(Request $request, InternshipApplication $application, ExamEngineService $examEngine)
    {
        $request->validate([
            'terms_accepted' => 'required|accepted',
        ], [
            'terms_accepted.required' => 'You must accept the terms and conditions to proceed.',
            'terms_accepted.accepted' => 'You must accept the terms and conditions to proceed.',
        ]);

        $application->update([
            'terms_accepted'    => true,
            'terms_accepted_at' => now(),
            'status'            => 'terms_accepted',
        ]);

        // Create exam attempt
        $attempt = $examEngine->createAttempt($application);

        // Check if there are enough questions
        if ($attempt->total_questions < 5) {
            $attempt->delete();
            return back()->with('error', 'Not enough questions available for this category. Please contact support.');
        }

        return redirect()->route('internship.exam', $attempt)
            ->with('success', 'Terms accepted! Your exam is ready. Good luck!');
    }
}
