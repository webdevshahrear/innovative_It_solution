<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\CrmActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InquiryAnalyticsController extends Controller
{
    public function index()
    {
        // 1. Funnel Data
        $stages = ['new', 'contacted', 'qualified', 'proposal_sent', 'won', 'lost'];
        $funnelData = [];
        foreach ($stages as $stage) {
            $funnelData[$stage] = ContactSubmission::where('status', $stage)->count();
        }

        // 2. Revenue Projection (Weighted)
        // Won=100%, Proposal Sent=60%, Qualified=30%, Contacted=10%, New=5%
        $weights = [
            'won' => 1.0,
            'proposal_sent' => 0.6,
            'qualified' => 0.3,
            'contacted' => 0.1,
            'new' => 0.05,
            'lost' => 0
        ];

        $projectedRevenue = 0;
        foreach ($weights as $status => $weight) {
            $val = ContactSubmission::where('status', $status)->sum('lead_value');
            $projectedRevenue += ($val * $weight);
        }

        // 3. Efficiency: Average Response Time (First activity after creation)
        // Simplified: Diff between created_at and first CrmActivity
        $avgResponseHours = 0;
        $leadsWithActivity = ContactSubmission::has('activities')->with(['activities' => function($q) {
            $q->orderBy('created_at', 'asc')->limit(1);
        }])->get();

        if ($leadsWithActivity->count() > 0) {
            $totalHours = 0;
            foreach ($leadsWithActivity as $lead) {
                if ($lead->activities->first()) {
                    $totalHours += $lead->created_at->diffInHours($lead->activities->first()->created_at);
                }
            }
            $avgResponseHours = $totalHours / $leadsWithActivity->count();
        }

        // 4. Stagnant Leads (No activity in last 72 hours, excluding won/lost)
        $stagnantLeads = ContactSubmission::whereNotIn('status', ['won', 'lost'])
            ->where(function($query) {
                $query->whereDoesntHave('activities')
                      ->orWhereHas('activities', function($q) {
                          $q->where('created_at', '<', now()->subDays(3));
                      });
            })
            ->latest()
            ->take(10)
            ->get();

        // 5. Conversion Rate (Won / Total)
        $totalLeads = ContactSubmission::count();
        $wonLeads = ContactSubmission::where('status', 'won')->count();
        $conversionRate = $totalLeads > 0 ? ($wonLeads / $totalLeads) * 100 : 0;

        return view('admin.inquiries.insights', compact(
            'funnelData',
            'projectedRevenue',
            'avgResponseHours',
            'stagnantLeads',
            'conversionRate',
            'totalLeads'
        ));
    }
}
