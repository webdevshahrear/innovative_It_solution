<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadEnrichmentService
{
    public static function enrich($lead)
    {
        if (!$lead->website_url) return $lead;

        try {
            $response = Http::timeout(3)->get($lead->website_url);
            
            if ($response->successful()) {
                $html = $response->body();
                
                // Fetch Title
                if (preg_match('/<title>(.*?)<\/title>/is', $html, $matches)) {
                    $title = trim($matches[1]);
                    $lead->notes()->create([
                        'admin_id' => 1, // System default
                        'content' => "Enriched Data: Website title found: '{$title}'",
                        'type' => 'note'
                    ]);
                }
                
                // Fetch Favicon
                if (preg_match('/<link.*?rel=["\' ](?:shortcut )?icon["\' ].*?href=["\' ](.*?)["\' ].*?>/is', $html, $matches)) {
                    $favicon = $matches[1];
                    // Logic to store favicon could go here
                }
            }
        } catch (\Exception $e) {
            Log::warning("Enrichment failed for lead {$lead->id}: " . $e->getMessage());
        }

        return $lead;
    }
}
