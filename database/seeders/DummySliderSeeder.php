<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlide;

class DummySliderSeeder extends Seeder
{
    public function run()
    {
        // Clear existing slides to avoid clutter
        HeroSlide::truncate();

        $slides = [
            [
                'title' => 'Cognitive AI Logic',
                'subtitle' => 'Harnessing the power of autonomous intelligence to redefine digital boundaries through neural network orchestration.',
                'image_path' => 'ai_hero_premium.png',
                'button_text' => 'Initiate Uplink',
                'button_link' => '/services',
                'status' => 'active',
                'display_order' => 1
            ],
            [
                'title' => 'Cyber Security Evolved',
                'subtitle' => 'Deployment of multi-layered defensive protocols for mission-critical infrastructure and global data integrity.',
                'image_path' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop',
                'button_text' => 'Secure Assets',
                'button_link' => '/services',
                'status' => 'active',
                'display_order' => 2
            ],
            [
                'title' => 'Cloud Scale Architecture',
                'subtitle' => 'Orchestrate global-scale systems with liquid-elasticity and near-zero latency for the modular digital future.',
                'image_path' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop',
                'button_text' => 'View Capabilities',
                'button_link' => '/services',
                'status' => 'active',
                'display_order' => 3
            ],
            [
                'title' => 'Software Excellence',
                'subtitle' => 'Building bespoke digital experiences tailored for high-growth enterprises and disruptive startups.',
                'image_path' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=2072&auto=format&fit=crop',
                'button_text' => 'Start Project',
                'button_link' => '/services',
                'status' => 'active',
                'display_order' => 4
            ],
            [
                'title' => 'Business Transformation',
                'subtitle' => 'strategic alignment of technology and vision to accelerate your journey towards digital maturity.',
                'image_path' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2015&auto=format&fit=crop',
                'button_text' => 'Consult Now',
                'button_link' => '/contact',
                'status' => 'active',
                'display_order' => 5
            ],
            [
                'title' => 'Global Connectivity',
                'subtitle' => 'Bridging distances with high-performance networking and communication protocols for a borderless world.',
                'image_path' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=2070&auto=format&fit=crop',
                'button_text' => 'Explore Network',
                'button_link' => '/services',
                'status' => 'active',
                'display_order' => 6
            ],
            [
                'title' => 'Innovation Labs',
                'subtitle' => 'Where radical ideas meet practical engineering to create the technologies of tomorrow, today.',
                'image_path' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop',
                'button_text' => 'Join Future',
                'button_link' => '/about',
                'status' => 'active',
                'display_order' => 7
            ]
        ];


        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }
    }
}
