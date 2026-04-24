<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternshipCategory;

class InternshipCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Web Design',             'slug' => 'web-design',             'icon' => 'fas fa-palette',          'description' => 'HTML, CSS, responsive design, UI principles'],
            ['name' => 'Web Development',        'slug' => 'web-development',        'icon' => 'fas fa-code',             'description' => 'PHP, Laravel, JavaScript, backend development'],
            ['name' => 'Graphics Design',        'slug' => 'graphics-design',        'icon' => 'fas fa-pen-nib',          'description' => 'Adobe Photoshop, Illustrator, brand identity'],
            ['name' => 'UI/UX Design',           'slug' => 'ui-ux-design',           'icon' => 'fas fa-object-group',     'description' => 'Figma, wireframing, user research, prototyping'],
            ['name' => 'Video Editing',          'slug' => 'video-editing',          'icon' => 'fas fa-film',             'description' => 'Premiere Pro, After Effects, motion graphics'],
            ['name' => 'Digital Marketing',      'slug' => 'digital-marketing',      'icon' => 'fas fa-bullhorn',         'description' => 'Campaigns, analytics, PPC, email marketing'],
            ['name' => 'SEO',                    'slug' => 'seo',                    'icon' => 'fas fa-search',           'description' => 'On-page SEO, keyword research, link building'],
            ['name' => 'Content Writing',        'slug' => 'content-writing',        'icon' => 'fas fa-feather-alt',      'description' => 'Blog writing, copywriting, content strategy'],
            ['name' => 'Social Media Management','slug' => 'social-media-management','icon' => 'fas fa-share-alt',        'description' => 'Facebook, Instagram, content calendar, analytics'],
            ['name' => 'App Development',        'slug' => 'app-development',        'icon' => 'fas fa-mobile-alt',       'description' => 'React Native, Flutter, mobile UI/UX'],
        ];

        foreach ($categories as $index => $cat) {
            InternshipCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['display_order' => $index + 1, 'is_active' => true])
            );
        }
    }
}
