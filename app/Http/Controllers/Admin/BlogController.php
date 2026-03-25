<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::latest()->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author'] = $validated['author'] ?? Auth::user()->name ?? 'Admin';

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog', 'public');
            $validated['featured_image'] = basename($path);
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
            'author' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        if ($blog->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image && Storage::disk('public')->exists('blog/' . $blog->featured_image)) {
                Storage::disk('public')->delete('blog/' . $blog->featured_image);
            }
            
            $path = $request->file('featured_image')->store('blog', 'public');
            $validated['featured_image'] = basename($path);
        }

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blog)
    {
        if ($blog->image && Storage::disk('public')->exists('blog/' . $blog->image)) {
            Storage::disk('public')->delete('blog/' . $blog->image);
        }

        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }

    public function duplicate(BlogPost $blog)
    {
        $newPost = $blog->replicate();
        $newPost->title = $blog->title . ' (Copy)';
        $newPost->slug = Str::slug($newPost->title);
        $newPost->status = 'draft'; // Default copies to draft
        $newPost->created_at = now();
        $newPost->save();

        return redirect()->route('admin.blog.index')->with('success', 'Intel bulletin cloned and set to draft status.');
    }
}
