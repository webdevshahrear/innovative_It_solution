<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Checking 'hero_slides' table...\n";

if (Schema::hasColumn('hero_slides', 'order_position')) {
    echo "Found 'order_position', renaming to 'display_order'...\n";
    try {
        DB::statement('ALTER TABLE hero_slides CHANGE order_position display_order INT DEFAULT 0');
        echo "Success: Renamed 'order_position' to 'display_order'.\n";
    } catch (\Exception $e) {
        echo "Error renaming: " . $e->getMessage() . "\n";
    }
} elseif (Schema::hasColumn('hero_slides', 'display_order')) {
    echo "Column 'display_order' already exists. No action needed.\n";
} else {
    echo "Neither column found! Creating 'display_order'...\n";
    try {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->integer('display_order')->default(0);
        });
        echo "Success: Created 'display_order'.\n";
    } catch (\Exception $e) {
        echo "Error creating column: " . $e->getMessage() . "\n";
    }
}

echo "Done.\n";
