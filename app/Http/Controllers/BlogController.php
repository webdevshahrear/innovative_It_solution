<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Blog - WebBoost Lab';
        $query = BlogPost::where('status', 'published')->orderBy('created_at', 'desc');

        // TODO: Add category column to blog_posts table
        // if ($request->has('category')) {
        //     $query->where('category', $request->category);
        // }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->paginate(6);
        $categories = []; // Empty array until category column is added

        return \view('blog.index', compact('pageTitle', 'posts', 'categories'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $pageTitle = $post->title . ' - WebBoost Lab Blog';
        $recentPosts = BlogPost::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return \view('blog.show', compact('pageTitle', 'post', 'recentPosts'));
    }
}
