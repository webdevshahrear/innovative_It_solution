<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Disable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=0;');

$tables = ['hero_slides', 'testimonials', 'site_settings'];

foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        Schema::drop($table);
        echo "Dropped table: $table\n";
    } else {
        echo "Table not found: $table\n";
    }
    // Also remove from migrations table to ensure it re-runs
    DB::table('migrations')->where('migration', 'like', "%create_{$table}_table%")->delete();
}

DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "Done.\n";
