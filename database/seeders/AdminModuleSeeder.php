<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactSubmission;
use App\Models\Subscriber;
use App\Models\Statistic;

class AdminModuleSeeder extends Seeder
{
    public function run(): void
    {
        // Contact Submissions (Inquiries)
        $inquiries = [
            [
                'name' => 'Dr. Aris Thorne',
                'email' => 'thorne@cyberia.io',
                'subject' => 'Quantum Encryption Protocol Inquiry',
                'message' => 'Seeking detailed specifications on your latest secure communication uplinks for deep-space telemetry.',
                'status' => 'new'
            ],
            [
                'name' => 'Sarah Jenkins',
                'email' => 'sarah.j@techflow.net',
                'subject' => 'V3 System Integration',
                'message' => 'We are interested in integrating your new V3 design language into our modular dashboard system.',
                'status' => 'new'
            ],
            [
                'name' => 'Marco Valti',
                'email' => 'm.valti@nexus.it',
                'subject' => 'Partnership Uplink',
                'message' => 'The Nexus group is looking for strategic partners in the agile development sector. Your portfolio is impressive.',
                'status' => 'read'
            ],
            [
                'name' => 'Elena Rossi',
                'email' => 'elena@vivid-designs.com',
                'subject' => 'Bento Grid Implementation',
                'message' => 'How do you handle the responsive collapse of your bento grid layouts? I\'d love to compare notes.',
                'status' => 'read'
            ],
        ];

        foreach ($inquiries as $inquiry) {
            ContactSubmission::updateOrCreate(
                ['email' => $inquiry['email'], 'subject' => $inquiry['subject']],
                $inquiry
            );
        }

        // Subscribers
        $emails = [
            'tech-enthusiast@gmail.com',
            'dev-ops-guru@cloud.com',
            'ux-master@framer.io',
            'startup-founder@horizon.vc',
            'ai-researcher@deepmind.ai'
        ];

        foreach ($emails as $email) {
            Subscriber::updateOrCreate(['email' => $email], ['status' => 'active']);
        }

        // Statistics
        $metrics = [
            [
                'stat_key' => 'global_users',
                'stat_label' => 'Global Operatives',
                'stat_value' => '25k+',
                'icon_class' => 'fas fa-globe-americas',
                'display_order' => 1
            ],
            [
                'stat_key' => 'uplinks_established',
                'stat_label' => 'Uplinks Established',
                'stat_value' => '1.2M',
                'icon_class' => 'fas fa-satellite-dish',
                'display_order' => 2
            ],
            [
                'stat_key' => 'data_processed',
                'stat_label' => 'Data Processed',
                'stat_value' => '8.4 PB',
                'icon_class' => 'fas fa-microchip',
                'display_order' => 3
            ],
            [
                'stat_key' => 'uptime_status',
                'stat_label' => 'System Uptime',
                'stat_value' => '99.99%',
                'icon_class' => 'fas fa-server',
                'display_order' => 4
            ],
        ];

        foreach ($metrics as $metric) {
            Statistic::updateOrCreate(['stat_key' => $metric['stat_key']], $metric);
        }
    }
}
