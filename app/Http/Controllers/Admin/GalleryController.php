<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::orderBy('display_order')->get();
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'image_path' => 'required|image|max:5120', // Max 5MB for high-res
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/gallery'), $filename);
            $validated['image_path'] = $filename;
        }

        GalleryItem::create($validated + ['display_order' => GalleryItem::max('display_order') + 1]);

        return redirect()->route('admin.gallery-items.index')->with('success', 'Visual asset indexed.');
    }

    public function edit(GalleryItem $gallery_item)
    {
        return view('admin.gallery.edit', compact('gallery_item'));
    }

    public function update(Request $request, GalleryItem $gallery_item)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|max:5120',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
        ]);

        if ($request->hasFile('image_path')) {
            if ($gallery_item->image_path) {
                @unlink(public_path('uploads/gallery/' . $gallery_item->image_path));
            }
            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/gallery'), $filename);
            $validated['image_path'] = $filename;
        }

        $gallery_item->update($validated);

        return redirect()->route('admin.gallery-items.index')->with('success', 'Visual asset recalibrated.');
    }

    public function destroy(GalleryItem $gallery_item)
    {
        if ($gallery_item->image_path) {
            @unlink(public_path('uploads/gallery/' . $gallery_item->image_path));
        }

        $gallery_item->delete();
        return redirect()->route('admin.gallery-items.index')->with('success', 'Asset purged from archives.');
    }
}
