<?php

namespace App\Http\Controllers\Admin\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipNotice;
use App\Models\InternshipCategory;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = InternshipNotice::with('postedBy', 'targetCategory')
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.internship.notices.index', compact('notices'));
    }

    public function create()
    {
        $categories = InternshipCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.internship.notices.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'content'            => 'required|string',
            'target_audience'    => 'required|in:all,specific_category',
            'target_category_id' => 'nullable|required_if:target_audience,specific_category|exists:internship_categories,id',
            'is_pinned'          => 'boolean',
            'published_at'       => 'nullable|date',
        ]);

        InternshipNotice::create([
            'posted_by'          => auth()->id(),
            'title'              => $request->title,
            'content'            => $request->content,
            'target_audience'    => $request->target_audience,
            'target_category_id' => $request->target_category_id,
            'is_pinned'          => $request->boolean('is_pinned'),
            'published_at'       => $request->published_at ?? now(),
        ]);

        return redirect()->route('admin.internship.notices.index')
            ->with('success', 'Notice published.');
    }

    public function edit(InternshipNotice $notice)
    {
        $categories = InternshipCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.internship.notices.edit', compact('notice', 'categories'));
    }

    public function update(Request $request, InternshipNotice $notice)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'content'            => 'required|string',
            'target_audience'    => 'required|in:all,specific_category',
            'target_category_id' => 'nullable|exists:internship_categories,id',
            'is_pinned'          => 'boolean',
        ]);

        $notice->update([
            'title'              => $request->title,
            'content'            => $request->content,
            'target_audience'    => $request->target_audience,
            'target_category_id' => $request->target_audience === 'all' ? null : $request->target_category_id,
            'is_pinned'          => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('admin.internship.notices.index')
            ->with('success', 'Notice updated.');
    }

    public function destroy(InternshipNotice $notice)
    {
        $notice->delete();
        return back()->with('success', 'Notice deleted.');
    }
}
