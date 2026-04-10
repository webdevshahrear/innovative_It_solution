<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\ContactSubmission;

class ContactController extends Controller
{
    public function index()
    {
        $pageTitle = 'Contact Us - ' . SiteSetting::getValue('site_title', 'Innovative IT Solutions');
        $contactEmail = SiteSetting::where('setting_key', 'contact_email')->value('setting_value') ?? 'hello@innovativeitsolutions.com';
        $contactPhone = SiteSetting::where('setting_key', 'contact_phone')->value('setting_value') ?? '+1 (555) 123-4567';
        $contactAddress = SiteSetting::where('setting_key', 'contact_address')->value('setting_value') ?? '123 Web St, Tech City';

        return \view('contact', compact('pageTitle', 'contactEmail', 'contactPhone', 'contactAddress'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $lead = ContactSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'website_url' => $validated['website_url'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Phase 3: Automation - Send Welcome Email
        try {
            \Illuminate\Support\Facades\Mail::to($lead->email)->send(new \App\Mail\LeadWelcomeMail($lead));
        } catch (\Exception $e) {
            \Illuminate\Support\Log::error('Mail failed: ' . $e->getMessage());
        }

        // Phase 3: Intelligence - Lead Enrichment
        \App\Services\LeadEnrichmentService::enrich($lead);

        return redirect()->back()->with('success', 'Thank you! Your inquiry has been received. Please check your email for a confirmation.');
    }
}
