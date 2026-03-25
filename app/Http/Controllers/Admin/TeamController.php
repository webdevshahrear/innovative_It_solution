<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('display_order')->get();
        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team'), $filename);
            $validated['image'] = $filename;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->image_url;
        }

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('success', 'Team member added successfully.');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($team->image && !filter_var($team->image, FILTER_VALIDATE_URL)) {
                @unlink(public_path('uploads/team/' . $team->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team'), $filename);
            $validated['image'] = $filename;
        } elseif ($request->filled('image_url')) {
            if ($team->image && !filter_var($team->image, FILTER_VALIDATE_URL)) {
                @unlink(public_path('uploads/team/' . $team->image));
            }
            $validated['image'] = $request->image_url;
        }

        $team->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->image && !filter_var($team->image, FILTER_VALIDATE_URL)) {
            @unlink(public_path('uploads/team/' . $team->image));
        }

        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }

    public function duplicate(TeamMember $team)
    {
        $newMember = $team->replicate();
        $newMember->name = $team->name . ' (Copy)';
        $newMember->display_order = TeamMember::max('display_order') + 1;
        $newMember->created_at = now();
        $newMember->save();

        return redirect()->route('admin.team.index')->with('success', 'Operative profile cloned successfully.');
    }
}
