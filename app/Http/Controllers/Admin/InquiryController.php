<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = ContactSubmission::latest()->paginate(15);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(ContactSubmission $inquiry)
    {
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'read']);
        }
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function destroy(ContactSubmission $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }

    public function markAsRead(ContactSubmission $inquiry)
    {
        $inquiry->update(['status' => 'read']);
        return back()->with('success', 'Marked as read.');
    }
}
