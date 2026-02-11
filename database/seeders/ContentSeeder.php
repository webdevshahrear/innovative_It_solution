<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ContentSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // 1. Site Settings
        $settings = [
            // General
            ['setting_key' => 'site_title', 'setting_value' => 'WebBoost Lab', 'group' => 'general'],
            ['setting_key' => 'site_description', 'setting_value' => 'Premium Web Development Agency', 'group' => 'general'],
            ['setting_key' => 'site_logo', 'setting_value' => 'logo.png', 'group' => 'general'],
            ['setting_key' => 'company_mission', 'setting_value' => 'To empower businesses with cutting-edge digital solutions.', 'group' => 'general'],
            ['setting_key' => 'company_vision', 'setting_value' => 'To be the global leader in innovative web technologies.', 'group' => 'general'],
            
            // Hero
            ['setting_key' => 'hero_mode', 'setting_value' => 'slider', 'group' => 'hero'],
            ['setting_key' => 'hero_title', 'setting_value' => 'Transforming Ideas into Digital Reality', 'group' => 'hero'],
            ['setting_key' => 'hero_subtitle', 'setting_value' => 'We build scalable, high-performance web applications.', 'group' => 'hero'],

            // Contact
            ['setting_key' => 'contact_email', 'setting_value' => 'hello@webboostlab.com', 'group' => 'contact'],
            ['setting_key' => 'contact_phone', 'setting_value' => '+1 (555) 123-4567', 'group' => 'contact'],

            // Colors (Defaults)
            ['setting_key' => 'primary_color', 'setting_value' => '#4f46e5', 'group' => 'appearance'],
            ['setting_key' => 'secondary_color', 'setting_value' => '#ec4899', 'group' => 'appearance'],
            ['setting_key' => 'accent_color', 'setting_value' => '#f59e0b', 'group' => 'appearance'],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['setting_key' => $setting['setting_key']],
                $setting
            );
        }

        // 2. Hero Slides
        DB::table('hero_slides')->truncate();
        DB::table('hero_slides')->insert([
            [
                'title' => 'Next-Gen Web Solutions',
                'subtitle' => 'Elevate your business with our premium web development services.',
                'image_path' => 'hero1.jpg',
                'button_text' => 'Get Started',
                'button_link' => '/contact',
                'display_order' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Digital Marketing Mastery',
                'subtitle' => 'Drive traffic and convert leads with our expert marketing strategies.',
                'image_path' => 'hero2.jpg',
                'button_text' => 'Learn More',
                'button_link' => '/services',
                'display_order' => 2,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // 3. Services
        DB::table('services')->truncate();
        DB::table('services')->insert([
            [
                'title' => 'Web Development',
                'slug' => 'web-development',
                'short_description' => 'Custom websites built with modern technologies like Laravel and React.',
                'icon_class' => 'fas fa-code',
                'display_order' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'short_description' => 'User-centric designs that provide exceptional digital experiences.',
                'icon_class' => 'fas fa-paint-brush',
                'display_order' => 2,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'SEO Optimization',
                'slug' => 'seo-optimization',
                'short_description' => 'Improve your search engine rankings and drive organic traffic.',
                'icon_class' => 'fas fa-search',
                'display_order' => 3,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // 4. Testimonials
        DB::table('testimonials')->truncate();
        DB::table('testimonials')->insert([
            [
                'client_name' => 'John Doe',
                'client_position' => 'CEO, TechCorp',
                'client_image' => 'client1.jpg',
                'content' => 'WebBoost Lab transformed our online presence. Highly recommended!',
                'rating' => 5,
                'display_order' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_name' => 'Jane Smith',
                'client_position' => 'Marketing Director, CreativeStudio',
                'client_image' => 'client2.jpg',
                'content' => 'Professional, creative, and timely. A pleasure to work with.',
                'rating' => 5,
                'display_order' => 2,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // 5. Team Members
        DB::table('team_members')->truncate();
        DB::table('team_members')->insert([
            [
                'name' => 'Michael Scott',
                'position' => 'Regional Manager',
                'image' => 'team1.jpg',
                'display_order' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Dwight Schrute',
                'position' => 'Assistant to the Regional Manager',
                'image' => 'team2.jpg',
                'display_order' => 2,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // 6. Statistics
        DB::table('statistics')->truncate();
        DB::table('statistics')->insert([
            ['stat_key' => 'projects_completed', 'stat_label' => 'Projects Completed', 'stat_value' => '500+', 'icon_class' => 'fas fa-project-diagram', 'display_order' => 1, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['stat_key' => 'happy_clients', 'stat_label' => 'Happy Clients', 'stat_value' => '300+', 'icon_class' => 'fas fa-smile', 'display_order' => 2, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['stat_key' => 'awards_won', 'stat_label' => 'Awards Won', 'stat_value' => '25', 'icon_class' => 'fas fa-trophy', 'display_order' => 3, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['stat_key' => 'years_experience', 'stat_label' => 'Years Experience', 'stat_value' => '10+', 'icon_class' => 'fas fa-calendar-alt', 'display_order' => 4, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
        
        // 7. Projects (Dummy)
        DB::table('projects')->truncate();
        DB::table('projects')->insert([
            [
                'title' => 'E-Commerce Platform',
                'slug' => 'e-commerce-platform',
                'desktop_image' => 'project1.jpg',
                'featured' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Corporate Portfolio',
                'slug' => 'corporate-portfolio',
                'desktop_image' => 'project2.jpg',
                'featured' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

         // 8. Blog Posts (Dummy)
        DB::table('blog_posts')->truncate();
        DB::table('blog_posts')->insert([
             [
                'title' => 'The Future of Web Design',
                'slug' => 'future-of-web-design',
                'excerpt' => 'Discover the trends shaping the digital landscape in 2026.',
                'content' => 'Full content here...',
                'featured_image' => 'blog1.jpg',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Optimizing Laravel Performance',
                'slug' => 'optimizing-laravel-performance',
                'excerpt' => 'Tips and tricks to make your Laravel application fly.',
                'content' => 'Full content here...',
                'featured_image' => 'blog2.jpg',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // 9. Project Categories
        DB::table('project_categories')->truncate();
        $catId1 = DB::table('project_categories')->insertGetId([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $catId2 = DB::table('project_categories')->insertGetId([
            'name' => 'UI/UX Design',
            'slug' => 'ui-ux-design',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 10. Project Category Relations
        DB::table('project_category_relations')->truncate();
        $projects = DB::table('projects')->get();
        foreach ($projects as $project) {
            DB::table('project_category_relations')->insert([
                'project_id' => $project->id,
                'category_id' => ($project->id % 2 == 0) ? $catId2 : $catId1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
