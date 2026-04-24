<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Illuminate\Support\Str;

$services = [
    [
        'title' => 'Custom System Development',
        'icon_class' => 'fas fa-laptop-code',
        'short_description' => 'Bespoke software systems tailored to your unique operational and business requirements.',
        'full_description' => 'We design, develop, and deploy complex custom system solutions from scratch. Whether it is an ERP, CRM, or a unique enterprise platform, our custom software architecture guarantees scalability, high performance, and exact alignment with your business workflows.',
    ],
    [
        'title' => 'Enterprise Web Applications',
        'icon_class' => 'fas fa-globe',
        'short_description' => 'High-performance, secure, and scalable web platforms built for the enterprise tier.',
        'full_description' => 'Our web applications are built on state-of-the-art frameworks to handle high traffic and immense data loads. We prioritize blazing-fast performance, intuitive UI, and ironclad security protocols to serve enterprises globally.',
    ],
    [
        'title' => 'Mobile App Development',
        'icon_class' => 'fas fa-mobile-alt',
        'short_description' => 'Native and cross-platform mobile experiences that engage and retain users.',
        'full_description' => 'From iOS to Android, we engineer fluid and dynamic mobile apps. Using technologies like Flutter, React Native, or pure native code, we deliver apps that run flawlessly and provide a premium user experience on any device.',
    ],
    [
        'title' => 'UI/UX & Product Design',
        'icon_class' => 'fas fa-palette',
        'short_description' => 'Human-centric design strategies that turn complex ideas into beautiful, intuitive interfaces.',
        'full_description' => 'We believe aesthetics drive interaction. Our design team conducts deep user research to craft wireframes, interactive prototypes, and high-fidelity UI/UX designs that guarantee both visual excellence and seamless usability.',
    ],
    [
        'title' => 'Cloud & DevOps Solutions',
        'icon_class' => 'fas fa-cloud',
        'short_description' => 'Robust cloud infrastructure setups with fully automated CI/CD pipelines.',
        'full_description' => 'Scale seamlessly without hardware limits. We implement optimized AWS, Azure, and Google Cloud environments while our DevOps pipelines ensure continuous integration, automated testing, and zero-downtime deployments.',
    ],
    [
        'title' => 'Artificial Intelligence & ML',
        'icon_class' => 'fas fa-robot',
        'short_description' => 'Intelligent algorithms that automate decisions and discover hidden business insights.',
        'full_description' => 'Harness the power of AI to outpace the competition. We build machine learning models, predictive analytics, and natural language processing agents that transform raw data into intelligent, actionable automation.',
    ],
    [
        'title' => 'Cybersecurity Solutions',
        'icon_class' => 'fas fa-shield-alt',
        'short_description' => 'Comprehensive penetration testing, vulnerability assessments, and threat mitigation.',
        'full_description' => 'Your data is your most valuable asset. We provide end-to-end security audits, implement zero-trust architectures, and offer real-time threat monitoring to protect your systems from sophisticated cyber attacks.',
    ],
    [
        'title' => 'IT Consulting & Strategy',
        'icon_class' => 'fas fa-chart-line',
        'short_description' => 'Expert guidance to navigate digital transformation and optimize tech investments.',
        'full_description' => 'Unsure of your tech roadmap? Our veteran consultants analyze your current infrastructure, identify bottlenecks, and formulate strategic digital transformation plans to future-proof your business operations.',
    ],
    [
        'title' => 'E-Commerce Solutions',
        'icon_class' => 'fas fa-shopping-cart',
        'short_description' => 'Feature-rich, highly convertible digital storefronts for B2B and B2C markets.',
        'full_description' => 'We create customized e-commerce platforms equipped with secure payment gateways, inventory management systems, and advanced product recommendation engines that maximize your revenue and conversion rates.',
    ],
    [
        'title' => 'Big Data & Analytics',
        'icon_class' => 'fas fa-database',
        'short_description' => 'Sophisticated data pipelines that turn massive datasets into strategic dashboards.',
        'full_description' => 'Make decisions based on facts, not guesses. We engineer robust data architectures, configure data lakes, and build real-time interactive dashboards that visualize critical KPIs across your entire organization.',
    ]
];

$order = 1;
foreach($services as $s) {
    // Check if a service with the same title exists to avoid duplicates
    if (!Service::where('title', $s['title'])->exists()) {
        $s['slug'] = Str::slug($s['title']);
        $s['rating'] = 5;
        $s['status'] = 'active';
        $s['display_order'] = $order++;
        Service::create($s);
    }
}
echo "Services inserted successfully!\n";
