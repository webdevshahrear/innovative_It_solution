<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TeamMember;

$dummyTeam = [
    [
        'name' => 'Alexander Pierce',
        'position' => 'Lead Data Scientist',
        'bio' => 'Expert in AI architectures and neural network deployment.',
        'image' => null,
        'facebook_url' => '#',
        'twitter_url' => '#',
        'linkedin_url' => '#',
        'instagram_url' => null,
        'status' => 'active',
        'display_order' => 5
    ],
    [
        'name' => 'Elena Rodriguez',
        'position' => 'VP of Engineering',
        'bio' => 'Scaling enterprise systems and cloud infrastructure.',
        'image' => null,
        'facebook_url' => null,
        'twitter_url' => '#',
        'linkedin_url' => '#',
        'instagram_url' => null,
        'status' => 'active',
        'display_order' => 6
    ],
    [
        'name' => 'Marcus Chen',
        'position' => 'Cybersecurity Head',
        'bio' => 'Securing critical infrastructure against modern threats.',
        'image' => null,
        'facebook_url' => '#',
        'twitter_url' => null,
        'linkedin_url' => '#',
        'instagram_url' => '#',
        'status' => 'active',
        'display_order' => 7
    ],
    [
        'name' => 'Sophia Patel',
        'position' => 'Chief Product Officer',
        'bio' => 'Designing user-centric enterprise platforms.',
        'image' => null,
        'facebook_url' => null,
        'twitter_url' => '#',
        'linkedin_url' => '#',
        'instagram_url' => null,
        'status' => 'active',
        'display_order' => 8
    ]
];

foreach ($dummyTeam as $member) {
    TeamMember::create($member);
}

echo "Added 4 dummy team members successfully.";
