<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $viewType = $request->get('view', 'list');
        
        if ($viewType === 'board') {
            $leadsByStatus = [
                'new'           => ContactSubmission::where('status', 'new')->latest()->get(),
                'contacted'     => ContactSubmission::where('status', 'contacted')->latest()->get(),
                'qualified'     => ContactSubmission::where('status', 'qualified')->latest()->get(),
                'proposal_sent' => ContactSubmission::where('status', 'proposal_sent')->latest()->get(),
                'won'           => ContactSubmission::where('status', 'won')->latest()->get(),
                'lost'          => ContactSubmission::where('status', 'lost')->latest()->get(),
            ];
            return view('admin.inquiries.board', compact('leadsByStatus'));
        }

        $inquiries = ContactSubmission::latest()->paginate(15);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(ContactSubmission $inquiry)
    {
        $inquiry->load(['notes.admin', 'convertedClient.projects', 'activities.user', 'assignee']);
        $admins = \App\Models\User::all();
        return view('admin.inquiries.show', compact('inquiry', 'admins'));
    }

    public function updateStatus(Request $request, ContactSubmission $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,qualified,proposal_sent,won,lost',
            'lead_value' => 'nullable|numeric'
        ]);

        $oldStatus = $inquiry->status;
        $inquiry->update($validated);
        
        if ($oldStatus !== $inquiry->status) {
            $this->logActivity($inquiry, 'status_change', "Status changed from " . strtoupper($oldStatus) . " to " . strtoupper($inquiry->status), [
                'old' => $oldStatus,
                'new' => $inquiry->status
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Lead status updated to ' . ucfirst($validated['status']),
                'lead' => $inquiry
            ]);
        }

        return back()->with('success', 'Lead status updated to ' . ucfirst($validated['status']));
    }

    public function assign(Request $request, ContactSubmission $inquiry)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        $inquiry->update($validated);
        $user = \App\Models\User::find($validated['assigned_to']);

        $this->logActivity($inquiry, 'assignment', "Lead assigned to " . $user->name, [
            'user_id' => $user->id,
            'user_name' => $user->name
        ]);

        return back()->with('success', 'Lead assigned to ' . $user->name);
    }

    public function addNote(Request $request, ContactSubmission $inquiry)
    {
        $request->validate([
            'content' => 'required|string',
            'type' => 'required|in:note,call,email,meeting',
            'attachment' => 'nullable|file|max:10240'
        ]);

        $noteData = [
            'admin_id' => auth()->id(),
            'content' => $request->content,
            'type' => $request->type
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('inquiry_attachments', 'public');
            $noteData['file_path'] = $path;
            $noteData['file_name'] = $file->getClientOriginalName();
        }

        $inquiry->notes()->create($noteData);
        
        $this->logActivity($inquiry, 'note', "Added a " . $request->type . " interaction log.");

        return back()->with('success', 'Note added successfully.');
    }

    protected function logActivity(ContactSubmission $inquiry, $type, $description, $metadata = null)
    {
        $inquiry->activities()->create([
            'user_id' => auth()->id(),
            'type' => $type,
            'description' => $description,
            'metadata' => $metadata
        ]);
    }

    public function convertToClient(ContactSubmission $inquiry)
    {
        if ($inquiry->convertedClient) {
            return back()->with('error', 'This lead is already converted to a client.');
        }

        $client = \App\Models\Client::create([
            'name' => $inquiry->name,
            'email' => $inquiry->email,
            'phone' => $inquiry->phone,
            'linkedin_url' => $inquiry->linkedin_url,
            'website_url' => $inquiry->website_url,
            'source_inquiry_id' => $inquiry->id,
            'total_revenue' => $inquiry->lead_value ?? 0
        ]);

        $inquiry->update(['status' => 'won']);
        $this->logActivity($inquiry, 'status_change', "Lead converted to Client.");

        return redirect()->route('admin.projects.create', ['client_id' => $client->id])
            ->with('success', 'Lead converted to Client successfully! Now you can create a project.');
    }

    public function destroy(ContactSubmission $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }


    public function duplicate(ContactSubmission $inquiry)
    {
        $newInquiry = $inquiry->replicate();
        $newInquiry->subject = $inquiry->subject . ' (Copy)';
        $newInquiry->status = 'new';
        $newInquiry->created_at = now();
        $newInquiry->save();

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry packets cloned successfully.');
    }

    public function setReminder(Request $request, ContactSubmission $inquiry)
    {
        $validated = $request->validate([
            'remind_at' => 'required|date|after:now',
            'priority' => 'required|in:low,medium,high'
        ]);

        $inquiry->update($validated);
        $this->logActivity($inquiry, 'note', "Set follow-up reminder for " . $inquiry->remind_at->format('M d, Y'));

        return back()->with('success', 'Follow-up reminder set for ' . $inquiry->remind_at->format('M d, Y H:i'));
    }
}
