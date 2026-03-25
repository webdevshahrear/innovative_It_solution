<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectCategoryController extends Controller
{
    public function index()
    {
        $categories = ProjectCategory::withCount('projects')->latest()->paginate(15);
        return view('admin.project-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.project-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:project_categories,name',
            'slug' => 'nullable|string|max:255|unique:project_categories,slug'
        ]);

        ProjectCategory::create([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name)
        ]);

        return redirect()->route('admin.project-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(ProjectCategory $project_category)
    {
        return view('admin.project-categories.edit', compact('project_category'));
    }

    public function update(Request $request, ProjectCategory $project_category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:project_categories,name,' . $project_category->id,
            'slug' => 'nullable|string|max:255|unique:project_categories,slug,' . $project_category->id
        ]);

        $project_category->update([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name)
        ]);

        return redirect()->route('admin.project-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ProjectCategory $project_category)
    {
        $project_category->delete();
        return redirect()->route('admin.project-categories.index')->with('success', 'Category deleted successfully.');
    }
}
