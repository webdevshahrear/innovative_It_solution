<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('projects') && !Schema::hasColumn('projects', 'tags')) {
            Schema::table('projects', function (Blueprint $blueprint) {
                $blueprint->string('tags')->nullable()->after('description');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('projects') && Schema::hasColumn('projects', 'tags')) {
            Schema::table('projects', function (Blueprint $blueprint) {
                $blueprint->dropColumn('tags');
            });
        }
    }
};
