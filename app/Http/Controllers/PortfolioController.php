<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\SiteSetting;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Our Portfolio - ' . SiteSetting::getValue('site_title', 'Innovative IT Solutions');
        $projectsRaw = Project::where('status', 'active')->orderBy('display_order')->with('categories')->get();
        $categories = ProjectCategory::all();

        // Pre-process for JS — no arrow functions in Blade @json()
        $projectsForJs = $projectsRaw->map(function ($p) {
            $isUrl = filter_var($p->desktop_image, FILTER_VALIDATE_URL);
            $placeholders = [
                'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80', // tech 1
                'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=800&q=80', // tech 2
                'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=800&q=80', // design 1
                'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80', // work 1
                'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=800&q=80', // team 1
                'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80', // coding 1
                'https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&q=80', // office 1
            ];
            $placeholderIdx = ($p->id ?? 0) % count($placeholders);

            $img = !empty($p->desktop_image)
                ? ($isUrl ? $p->desktop_image : asset('uploads/projects/' . $p->desktop_image))
                : $placeholders[$placeholderIdx];

            $cats = $p->categories->map(function ($c) {
                return ['slug' => $c->slug, 'name' => $c->name];
            })->values()->toArray();

            $tags = array_values(array_filter(array_map('trim', explode(',', $p->tags ?? ''))));

            return [
                'id'    => $p->id,
                'title' => $p->title,
                'url'   => $p->project_url ?: route('portfolio.show', $p->slug),
                'img'   => $img,
                'cats'  => $cats,
                'tags'  => $tags,
            ];
        })->values()->toArray();

        return \view('portfolio.index', compact('pageTitle', 'projectsForJs', 'categories'));
    }


    public function show($slug)
    {
        $project = Project::where('slug', $slug)->where('status', 'active')->with('categories')->firstOrFail();
        $pageTitle = $project->title . ' - Project Detail';
        $relatedProjects = Project::where('status', 'active')
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();

        return \view('portfolio.show', compact('pageTitle', 'project', 'relatedProjects'));
    }
}
