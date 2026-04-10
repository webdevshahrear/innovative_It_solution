<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects'       => \App\Models\Project::count(),
            'services'       => \App\Models\Service::count(),
            'team'           => \App\Models\TeamMember::count(),
            'new_inquiries'  => \App\Models\ContactSubmission::where('status', 'new')->count(),
            'total_inquiries'=> \App\Models\ContactSubmission::count(),
            'subscribers'    => \App\Models\Subscriber::count(),
            'blog_posts'     => \App\Models\BlogPost::count(),
            'testimonials'   => \App\Models\Testimonial::count(),
            'hero_slides'    => \App\Models\HeroSlide::count(),
            'statistics'     => \App\Models\Statistic::count(),
            'workflows'      => \App\Models\WorkFlow::count(),
            'clients'        => \App\Models\Client::count(),
            'pipeline_value' => \App\Models\ContactSubmission::whereNotIn('status', ['lost'])->sum('lead_value'),
            'conversion_rate'=> \App\Models\ContactSubmission::count() > 0 
                                ? (\App\Models\ContactSubmission::where('status', 'won')->count() / \App\Models\ContactSubmission::count()) * 100 
                                : 0,
        ];

        // Monthly inquiry data for chart (last 6 months)
        $monthly_inquiries = [];
        $monthly_labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthly_labels[] = $month->format('M Y');
            $monthly_inquiries[] = \App\Models\ContactSubmission::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Monthly projects data for chart (last 6 months)
        $monthly_projects = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthly_projects[] = \App\Models\Project::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        $category_stats = \App\Models\ProjectCategory::withCount('projects')->get();
        $recent_inquiries = \App\Models\ContactSubmission::latest()->take(6)->get();
        $recent_projects  = \App\Models\Project::with('categories')->latest()->take(5)->get();
        $recent_blog      = \App\Models\BlogPost::latest()->take(4)->get();

        // Quick action counts
        $quick = [
            'unread_msgs'    => \App\Models\ContactSubmission::where('status', 'new')->count(),
            'upcoming_reminders' => \App\Models\ContactSubmission::where('remind_at', '>=', now())
                                    ->where('remind_at', '<=', now()->addDays(7))
                                    ->orderBy('remind_at', 'asc')
                                    ->get(),
        ];

        return view('dashboard', compact(
            'stats',
            'recent_inquiries',
            'recent_projects',
            'recent_blog',
            'category_stats',
            'monthly_inquiries',
            'monthly_projects',
            'monthly_labels',
            'quick'
        ));
    }
}
