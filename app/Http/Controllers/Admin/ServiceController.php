<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('display_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon_class' => 'nullable|string|max:255',
            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
            'rating' => 'nullable|numeric|between:0,5',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon_class' => 'nullable|string|max:255',
            'short_description' => 'required|string',
            'full_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'display_order' => 'integer',
            'rating' => 'nullable|numeric|between:0,5',
        ]);

        if ($service->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
