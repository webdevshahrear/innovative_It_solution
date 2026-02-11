<?php

/**
 * Website Page Tester
 * Tests all frontend pages and reports errors
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== WebBoost Lab - Website Testing ===\n\n";

$routes = [
    ['GET', '/', 'Homepage'],
    ['GET', '/about', 'About Page'],
    ['GET', '/services', 'Services Page'],
    ['GET', '/team', 'Team Page'],
    ['GET', '/portfolio', 'Portfolio Page'],
    ['GET', '/blog', 'Blog Index'],
    ['GET', '/contact', 'Contact Page'],
];

$results = [];
$errors = [];

foreach ($routes as $route) {
    [$method, $uri, $name] = $route;
    
    echo "Testing: {$name} ({$uri})... ";
    
    try {
        $request = Illuminate\Http\Request::create($uri, $method);
        $response = $app->handle($request);
        
        $status = $response->getStatusCode();
        
        if ($status === 200) {
            echo "✓ OK\n";
            $results[] = ['route' => $name, 'status' => 'OK', 'code' => 200];
        } else {
            echo "✗ FAILED (Status: {$status})\n";
            $results[] = ['route' => $name, 'status' => 'FAILED', 'code' => $status];
            $errors[] = "{$name}: HTTP {$status}";
        }
        
    } catch (\Exception $e) {
        echo "✗ ERROR\n";
        $error = $e->getMessage();
        $results[] = ['route' => $name, 'status' => 'ERROR', 'error' => $error];
        $errors[] = "{$name}: {$error}";
    }
}

echo "\n=== Test Summary ===\n";
$passed = count(array_filter($results, fn($r) => $r['status'] === 'OK'));
$total = count($results);
echo "Passed: {$passed}/{$total}\n";

if (!empty($errors)) {
    echo "\n=== Errors Found ===\n";
    foreach ($errors as $error) {
        echo "- {$error}\n";
    }
} else {
    echo "\n✓ All tests passed!\n";
}

echo "\n";
