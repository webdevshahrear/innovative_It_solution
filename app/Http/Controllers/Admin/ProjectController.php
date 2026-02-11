<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('categories')->orderBy('display_order')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = ProjectCategory::all();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'desktop_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'mobile_image' => 'nullable|image|max:2048',
            'featured' => 'boolean',
            'display_order' => 'integer',
            'categories' => 'array'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('desktop_image')) {
            $path = $request->file('desktop_image')->store('projects', 'public');
            $validated['desktop_image'] = basename($path);
        }

        if ($request->hasFile('mobile_image')) {
            $path = $request->file('mobile_image')->store('projects', 'public');
            $validated['mobile_image'] = basename($path);
        }

        $project = Project::create($validated);

        if ($request->has('categories')) {
            $project->categories()->sync($request->categories);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $categories = ProjectCategory::all();
        $project->load('categories');
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'desktop_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'mobile_image' => 'nullable|image|max:2048',
            'featured' => 'boolean',
            'display_order' => 'integer',
            'categories' => 'array'
        ]);

        if ($project->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('desktop_image')) {
            // Delete old image if exists
            if ($project->desktop_image && Storage::disk('public')->exists('projects/' . $project->desktop_image)) {
                Storage::disk('public')->delete('projects/' . $project->desktop_image);
            }
            
            $path = $request->file('desktop_image')->store('projects', 'public');
            $validated['desktop_image'] = basename($path);
        }

        if ($request->hasFile('mobile_image')) {
            // Delete old image if exists
            if ($project->mobile_image && Storage::disk('public')->exists('projects/' . $project->mobile_image)) {
                Storage::disk('public')->delete('projects/' . $project->mobile_image);
            }
            $path = $request->file('mobile_image')->store('projects', 'public');
            $validated['mobile_image'] = basename($path);
        }

        $project->update($validated);

        if ($request->has('categories')) {
            $project->categories()->sync($request->categories);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->desktop_image && Storage::disk('public')->exists('projects/' . $project->desktop_image)) {
            Storage::disk('public')->delete('projects/' . $project->desktop_image);
        }
        
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
