<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::orderBy('display_order')->get();
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_class' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/achievements'), $filename);
            $validated['image'] = $filename;
        }

        Achievement::create($validated + ['display_order' => Achievement::max('display_order') + 1]);

        return redirect()->route('admin.achievements.index')->with('success', 'Legacy achievement recorded.');
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_class' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            if ($achievement->image) {
                @unlink(public_path('uploads/achievements/' . $achievement->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/achievements'), $filename);
            $validated['image'] = $filename;
        }

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')->with('success', 'Legacy record updated.');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->image) {
            @unlink(public_path('uploads/achievements/' . $achievement->image));
        }

        $achievement->delete();
        return redirect()->route('admin.achievements.index')->with('success', 'Achievement purged from records.');
    }
}
