<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Fixing 'statistics' table...\n";

// 1. Rename order_position to display_order
if (Schema::hasColumn('statistics', 'order_position')) {
    echo "Found 'order_position', renaming to 'display_order'...\n";
    try {
        DB::statement('ALTER TABLE statistics CHANGE order_position display_order INT DEFAULT 0');
        echo "Success: Renamed 'order_position' to 'display_order'.\n";
    } catch (\Exception $e) {
        echo "Error renaming: " . $e->getMessage() . "\n";
    }
} elseif (!Schema::hasColumn('statistics', 'display_order')) {
    echo "Creating 'display_order' column...\n";
    try {
        Schema::table('statistics', function (Blueprint $table) {
            $table->integer('display_order')->default(0);
        });
        echo "Success: Created 'display_order'.\n";
    } catch (\Exception $e) {
         echo "Error creating display_order: " . $e->getMessage() . "\n";
    }
}

// 2. Add status column
if (!Schema::hasColumn('statistics', 'status')) {
    echo "Creating 'status' column...\n";
    try {
        DB::statement("ALTER TABLE statistics ADD status ENUM('active', 'inactive') DEFAULT 'active'");
        echo "Success: Created 'status' column.\n";
    } catch (\Exception $e) {
        echo "Error creating status: " . $e->getMessage() . "\n";
    }
} else {
    echo "Column 'status' already exists.\n";
}

echo "Done.\n";
