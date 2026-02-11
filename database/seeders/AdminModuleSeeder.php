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
        // Contact Submissions
        ContactSubmission::updateOrCreate(
            ['email' => 'john@example.com', 'subject' => 'Website Redesign Inquiry'],
            [
                'name' => 'John Doe',
                'message' => 'I would like to inquire about redesigning my business website.',
                'status' => 'new'
            ]
        );

        ContactSubmission::updateOrCreate(
            ['email' => 'jane@example.com', 'subject' => 'SEO Services'],
            [
                'name' => 'Jane Smith',
                'message' => 'Do you provide monthly SEO maintenance?',
                'status' => 'read'
            ]
        );

        // Subscribers
        Subscriber::updateOrCreate(['email' => 'user1@example.com'], ['status' => 'active']);
        Subscriber::updateOrCreate(['email' => 'user2@example.com'], ['status' => 'active']);

        // Statistics
        Statistic::updateOrCreate(
            ['stat_key' => 'happy_clients'],
            [
                'stat_label' => 'Happy Clients',
                'stat_value' => '500+',
                'icon_class' => 'fas fa-smile',
                'status' => 'active',
                'display_order' => 1
            ]
        );
        Statistic::updateOrCreate(
            ['stat_key' => 'projects_completed'],
            [
                'stat_label' => 'Projects Completed',
                'stat_value' => '1.2k',
                'icon_class' => 'fas fa-check-circle',
                'status' => 'active',
                'display_order' => 2
            ]
        );
        Statistic::updateOrCreate(
            ['stat_key' => 'coffee_cups'],
            [
                'stat_label' => 'Coffee Cups',
                'stat_value' => '5k+',
                'icon_class' => 'fas fa-coffee',
                'status' => 'active',
                'display_order' => 3
            ]
        );
        Statistic::updateOrCreate(
            ['stat_key' => 'years_experience'],
            [
                'stat_label' => 'Years Experience',
                'stat_value' => '10+',
                'icon_class' => 'fas fa-calendar',
                'status' => 'active',
                'display_order' => 4
            ]
        );
    }
}
