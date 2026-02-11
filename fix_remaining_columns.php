<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

$tables = ['services', 'projects', 'team_members'];

foreach ($tables as $table) {
    echo "Checking table: $table\n";
    if (Schema::hasColumn($table, 'order_position')) {
        echo "Found 'order_position', renaming to 'display_order'...\n";
        try {
            DB::statement("ALTER TABLE $table CHANGE order_position display_order INT DEFAULT 0");
            echo "Success: Renamed 'order_position' to 'display_order' in $table.\n";
        } catch (\Exception $e) {
            echo "Error renaming in $table: " . $e->getMessage() . "\n";
        }
    } elseif (Schema::hasColumn($table, 'display_order')) {
        echo "Column 'display_order' already exists in $table. No action needed.\n";
    } else {
        echo "Neither column found in $table! Creating 'display_order'...\n";
        try {
            Schema::table($table, function (Blueprint $table) {
                $table->integer('display_order')->default(0);
            });
            echo "Success: Created 'display_order' in $table.\n";
        } catch (\Exception $e) {
            echo "Error creating column in $table: " . $e->getMessage() . "\n";
        }
    }
    echo "--------------------------------\n";
}

echo "All Done.\n";
