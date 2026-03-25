<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('display_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'client_image' => 'nullable|image|max:2048',
            'client_image_url' => 'nullable|url|max:2048',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('client_image')) {
            $path = $request->file('client_image')->store('testimonials', 'public');
            $validated['client_image'] = basename($path);
        } elseif ($request->filled('client_image_url')) {
            $validated['client_image'] = $request->client_image_url;
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'client_image' => 'nullable|image|max:2048',
            'client_image_url' => 'nullable|url|max:2048',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('client_image')) {
            if ($testimonial->client_image && Storage::disk('public')->exists('testimonials/' . $testimonial->client_image)) {
                Storage::disk('public')->delete('testimonials/' . $testimonial->client_image);
            }
            
            $path = $request->file('client_image')->store('testimonials', 'public');
            $validated['client_image'] = basename($path);
        } elseif ($request->filled('client_image_url')) {
            if ($testimonial->client_image && Storage::disk('public')->exists('testimonials/' . $testimonial->client_image)) {
                Storage::disk('public')->delete('testimonials/' . $testimonial->client_image);
            }
            $validated['client_image'] = $request->client_image_url;
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->client_image && Storage::disk('public')->exists('testimonials/' . $testimonial->client_image)) {
            Storage::disk('public')->delete('testimonials/' . $testimonial->client_image);
        }

        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }

    public function duplicate(Testimonial $testimonial)
    {
        $newTestimonial = $testimonial->replicate();
        $newTestimonial->client_name = $testimonial->client_name . ' (Copy)';
        $newTestimonial->display_order = Testimonial::max('display_order') + 1;
        $newTestimonial->created_at = now();
        $newTestimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Feedback signal cloned successfully.');
    }
}
