<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$data = [
    ['client_name' => 'Sarah Jenkins', 'client_position' => 'Marketing Director', 'content' => 'The system throughput has increased by 400% since the V3 deployment. Absolute technical brilliance. We are more than satisfied with their delivery.', 'status' => 'active', 'display_order' => 1],
    ['client_name' => 'David O Connor', 'client_position' => 'CEO, Quantum Solutions', 'content' => 'They didn\'t just build a website, they architected a digital empire for our brand. The attention to detail and scalability is truly top-tier.', 'status' => 'active', 'display_order' => 2],
    ['client_name' => 'Elena Rostova', 'client_position' => 'Head of IT', 'content' => 'Their integration of AI into our legacy systems was flawless. We experienced zero downtime and immediate improvements in workflow automation.', 'status' => 'active', 'display_order' => 3],
    ['client_name' => 'Michael Chang', 'client_position' => 'Founder, TechStart', 'content' => 'Innovative IT Solutions is by far the most reliable tech partner we have ever worked with. Their proactive communication is a game changer.', 'status' => 'active', 'display_order' => 4],
    ['client_name' => 'Jessica Alba', 'client_position' => 'Product Manager', 'content' => 'A visually stunning platform backed by an extremely robust backend. Our user engagement skyrocketed within weeks of the new launch.', 'status' => 'active', 'display_order' => 5]
];

foreach($data as $d) { 
    \App\Models\Testimonial::create($d); 
}
echo "Dummy testimonials inserted successfully!\n";
