<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('hero_slides', 'order_position')) {
            Schema::table('hero_slides', function (Blueprint $table) {
                $table->renameColumn('order_position', 'display_order');
            });
        }

        if (Schema::hasColumn('services', 'order_position')) {
            Schema::table('services', function (Blueprint $table) {
                $table->renameColumn('order_position', 'display_order');
            });
        }

        if (Schema::hasColumn('statistics', 'order_position')) {
            Schema::table('statistics', function (Blueprint $table) {
                $table->renameColumn('order_position', 'display_order');
            });
        }

        if (Schema::hasColumn('team_members', 'order_position')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->renameColumn('order_position', 'display_order');
            });
        }

        if (Schema::hasColumn('projects', 'order_position')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->renameColumn('order_position', 'display_order');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('hero_slides', 'display_order')) {
            Schema::table('hero_slides', function (Blueprint $table) {
                $table->renameColumn('display_order', 'order_position');
            });
        }

        if (Schema::hasColumn('services', 'display_order')) {
            Schema::table('services', function (Blueprint $table) {
                $table->renameColumn('display_order', 'order_position');
            });
        }

        if (Schema::hasColumn('statistics', 'display_order')) {
            Schema::table('statistics', function (Blueprint $table) {
                $table->renameColumn('display_order', 'order_position');
            });
        }

        if (Schema::hasColumn('team_members', 'display_order')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->renameColumn('display_order', 'order_position');
            });
        }

        if (Schema::hasColumn('projects', 'display_order')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->renameColumn('display_order', 'order_position');
            });
        }
    }
};
