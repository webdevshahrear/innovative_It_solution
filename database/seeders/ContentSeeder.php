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
            ['setting_key' => 'site_title', 'setting_value' => 'Innovative It Solutions', 'group' => 'general'],
            ['setting_key' => 'site_description', 'setting_value' => 'Premium Web Development Agency', 'group' => 'general'],
            ['setting_key' => 'site_logo', 'setting_value' => 'logo.png', 'group' => 'general'],
            ['setting_key' => 'company_mission', 'setting_value' => 'To empower businesses with cutting-edge digital solutions.', 'group' => 'general'],
            ['setting_key' => 'company_vision', 'setting_value' => 'To be the global leader in innovative web technologies.', 'group' => 'general'],
            
            // Hero
            ['setting_key' => 'hero_mode', 'setting_value' => 'slider', 'group' => 'hero'],
            ['setting_key' => 'hero_title', 'setting_value' => 'Transforming Ideas into Digital Reality', 'group' => 'hero'],
            ['setting_key' => 'hero_subtitle', 'setting_value' => 'We build scalable, high-performance web applications.', 'group' => 'hero'],

            // Contact
            ['setting_key' => 'contact_email', 'setting_value' => 'hello@innovativeitsolutions.com', 'group' => 'contact'],
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
                'title' => 'Quantum Architecture',
                'subtitle' => 'Building the foundational layers of the modular digital future.',
                'image_path' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop',
                'button_text' => 'Initiate Uplink',
                'button_link' => '/contact',
                'display_order' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Nexus Node Integration',
                'subtitle' => 'Seamless data synchronization across global operative networks.',
                'image_path' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop',
                'button_text' => 'Decode Protocols',
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
                'title' => 'Cyber-Core Engineering',
                'slug' => 'cyber-core-engineering',
                'short_description' => 'Architecting resilient backend matrices for mission-critical operations.',
                'icon_class' => 'fas fa-shield-halved',
                'display_order' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Neural interface Design',
                'slug' => 'neural-interface-design',
                'short_description' => 'Synthesizing organic UX with high-frequency digital interactions.',
                'icon_class' => 'fas fa-brain',
                'display_order' => 2,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Signal Optimization',
                'slug' => 'signal-optimization',
                'short_description' => 'Maximizing telemetry throughput and reducing architectural latency.',
                'icon_class' => 'fas fa-tower-broadcast',
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
                'client_name' => 'Commander Vector',
                'client_position' => 'Ops Director, Aegis Labs',
                'client_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1974&auto=format&fit=crop',
                'content' => 'The system throughput has increased by 400% since the V3 deployment. Absolute technical brilliance.',
                'rating' => 5,
                'display_order' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_name' => 'Agent K-7',
                'client_position' => 'Strategic Analyst',
                'client_image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=1974&auto=format&fit=crop',
                'content' => 'Their neural-interface designs are indistinguishable from organic flow. The future of interaction is here.',
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
                'name' => 'Elias Thorne',
                'position' => 'Chief Architect',
                'image' => 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&w=1974&auto=format&fit=crop',
                'display_order' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Anya Vostova',
                'position' => 'Neural Interface Lead',
                'image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961&auto=format&fit=crop',
                'display_order' => 2,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // 6. Statistics (Redundant, handled by AdminModuleSeeder or kept for legacy)
        DB::table('statistics')->truncate();
        DB::table('statistics')->insert([
            ['stat_key' => 'uplinks_active', 'stat_label' => 'Uplinks Active', 'stat_value' => '99.9%', 'icon_class' => 'fas fa-wifi', 'display_order' => 1, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['stat_key' => 'encrypted_bytes', 'stat_label' => 'Encrypted Bytes', 'stat_value' => '12.4 ZB', 'icon_class' => 'fas fa-lock', 'display_order' => 2, 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
        
        // 7. Projects (Dummy)
        DB::table('projects')->truncate();
        DB::table('projects')->insert([
            [
                'title' => 'Project: Obsidian Core',
                'slug' => 'project-obsidian-core',
                'desktop_image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc48?q=80&w=2070&auto=format&fit=crop',
                'featured' => 1,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Holographic Matrix Hub',
                'slug' => 'holographic-matrix-hub',
                'desktop_image' => 'https://images.unsplash.com/photo-1544256718-3bcf237f3974?q=80&w=2071&auto=format&fit=crop',
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
                'title' => 'The Singularity of UI',
                'slug' => 'singularity-of-ui',
                'excerpt' => 'When interfaces become extensions of cognitive function.',
                'content' => 'Full analysis on the convergence of digital and biological interfaces.',
                'featured_image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=1470&auto=format&fit=crop',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Decrypting Zero-Knowledge Proofs',
                'slug' => 'decrypting-zero-knowledge-proofs',
                'excerpt' => 'The next frontier of decentralized cryptographic validation.',
                'content' => 'Deep dive into ZK-Snarks and their role in the V3 privacy layer.',
                'featured_image' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?q=80&w=1470&auto=format&fit=crop',
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
