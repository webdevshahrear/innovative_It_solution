<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => \App\Models\Project::count(),
            'portfolio' => \App\Models\Project::count(), 
            'services' => \App\Models\Service::count(),
            'team' => \App\Models\TeamMember::count(),
            'new_inquiries' => \App\Models\ContactSubmission::where('status', 'new')->count(),
        ];

        $category_stats = \App\Models\ProjectCategory::withCount('projects')->get();

        $recent_inquiries = \App\Models\ContactSubmission::latest()->take(6)->get();
        $recent_projects = \App\Models\Project::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recent_inquiries', 'recent_projects', 'category_stats'));
    }
}
