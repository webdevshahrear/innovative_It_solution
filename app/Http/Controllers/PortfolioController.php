<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectCategory;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Our Portfolio - WebBoost Lab';
        $categoryFilter = $request->input('category', 'all');
        $query = Project::where('status', 'active')->orderBy('display_order');

        if ($categoryFilter !== 'all') {
            $query->whereHas('categories', function($q) use ($categoryFilter) {
                $q->where('slug', $categoryFilter);
            });
        }

        $projects = $query->paginate(12);
        $categories = ProjectCategory::all();

        return \view('portfolio.index', compact('pageTitle', 'projects', 'categories', 'categoryFilter'));
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
