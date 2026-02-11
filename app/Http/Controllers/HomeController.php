<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SiteSetting;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\Statistic;
use App\Models\TeamMember;
use App\Models\BlogPost;

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = SiteSetting::where('setting_key', 'site_title')->value('setting_value') ?? 'WebBoost Lab';
        
        // Hero Slides
        $heroSlides = DB::table('hero_slides')->where('status', 'active')->orderBy('display_order')->get();
        $heroMode = SiteSetting::where('setting_key', 'hero_mode')->value('setting_value') ?? 'slider';

        // Other Sections
        $services = Service::where('status', 'active')->orderBy('display_order')->take(6)->get();
        $projects = Project::with('categories')->where('featured', 1)->where('status', 'active')->take(4)->get();
        $portfolioStyle = SiteSetting::where('setting_key', 'portfolio_section_style')->value('setting_value') ?? 'classic-grid';
        
        $testimonials = Testimonial::where('status', 'active')->latest()->take(3)->get();
        $stats = Statistic::where('status', 'active')->orderBy('display_order')->get();
        $teamMembers = TeamMember::where('status', 'active')->orderBy('display_order')->take(4)->get();
        $posts = BlogPost::where('status', 'published')->latest()->take(3)->get();
        
        $mission = SiteSetting::where('setting_key', 'company_mission')->value('setting_value');
        $vision = SiteSetting::where('setting_key', 'company_vision')->value('setting_value');

        $heroTitle = SiteSetting::where('setting_key', 'hero_title')->value('setting_value');
        $heroSubtitle = SiteSetting::where('setting_key', 'hero_subtitle')->value('setting_value');

        return \view('home.index', compact(
            'pageTitle', 'heroSlides', 'heroMode',
            'services', 'projects', 'portfolioStyle', 'testimonials', 'stats', 'teamMembers', 
            'posts', 'mission', 'vision', 'heroTitle', 'heroSubtitle'
        ));
    }
}
