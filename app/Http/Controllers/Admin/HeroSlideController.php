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
            'image_path' => 'nullable|image|max:10000', 
            'image_url' => 'nullable|url|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/slider/'), $filename);
            $validated['image_path'] = $filename;
        } elseif ($request->filled('image_url')) {
            $validated['image_path'] = $request->image_url;
        } else {
            return back()->withErrors(['image_path' => 'Please provide an image.'])->withInput();
        }

        HeroSlide::create($validated);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide generated and deployed successfully.');
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
            'image_path' => 'nullable|image|max:10000',
            'image_url' => 'nullable|url|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('image_path')) {
            // Delete old file
            if ($heroSlide->image_path && file_exists(public_path('uploads/slider/' . $heroSlide->image_path))) {
                unlink(public_path('uploads/slider/' . $heroSlide->image_path));
            }
            
            $image = $request->file('image_path');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/slider/'), $filename);
            $validated['image_path'] = $filename;
        } elseif ($request->filled('image_url')) {
            if ($heroSlide->image_path && file_exists(public_path('uploads/slider/' . $heroSlide->image_path))) {
                unlink(public_path('uploads/slider/' . $heroSlide->image_path));
            }
            $validated['image_path'] = $request->image_url;
        }

        $heroSlide->update($validated);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide identity updated.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image_path && file_exists(public_path('uploads/slider/' . $heroSlide->image_path))) {
            unlink(public_path('uploads/slider/' . $heroSlide->image_path));
        }

        $heroSlide->delete();
        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide purged successfully.');
    }

    public function duplicate(HeroSlide $heroSlide)
    {
        $newSlide = $heroSlide->replicate();
        $newSlide->title = $heroSlide->title . ' (Copy)';
        $newSlide->display_order = HeroSlide::max('display_order') + 1;
        $newSlide->created_at = now();
        $newSlide->save();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Slide signal duplicated.');
    }

}
