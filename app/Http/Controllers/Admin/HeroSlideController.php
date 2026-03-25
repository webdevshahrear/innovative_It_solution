<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('display_order')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048', 
            'image_url' => 'nullable|url|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        // Custom validation check: need at least one image source
        if (!$request->hasFile('image_path') && !$request->filled('image_url')) {
            return back()->withErrors(['image_path' => 'Please provide either an image upload or an image URL.'])->withInput();
        }

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('hero-slides', 'public');
            $validated['image_path'] = basename($path);
        } else {
            $validated['image_path'] = $request->image_url;
        }

        HeroSlide::create($validated);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide added successfully.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('image_path')) {
            if ($heroSlide->image_path && Storage::disk('public')->exists('hero-slides/' . $heroSlide->image_path)) {
                Storage::disk('public')->delete('hero-slides/' . $heroSlide->image_path);
            }
            
            $path = $request->file('image_path')->store('hero-slides', 'public');
            $validated['image_path'] = basename($path);
        } elseif ($request->filled('image_url')) {
            // If they provided a URL, we use that. 
            // Optional: delete old file if it existed
            if ($heroSlide->image_path && Storage::disk('public')->exists('hero-slides/' . $heroSlide->image_path)) {
                Storage::disk('public')->delete('hero-slides/' . $heroSlide->image_path);
            }
            $validated['image_path'] = $request->image_url;
        }

        $heroSlide->update($validated);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image_path && Storage::disk('public')->exists('hero-slides/' . $heroSlide->image_path)) {
            Storage::disk('public')->delete('hero-slides/' . $heroSlide->image_path);
        }

        $heroSlide->delete();
        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide deleted successfully.');
    }

    public function duplicate(HeroSlide $heroSlide)
    {
        $newSlide = $heroSlide->replicate();
        $newSlide->title = $heroSlide->title . ' (Copy)';
        $newSlide->display_order = HeroSlide::max('display_order') + 1;
        $newSlide->created_at = now();
        $newSlide->save();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Banner signal duplicated successfully.');
    }
}
