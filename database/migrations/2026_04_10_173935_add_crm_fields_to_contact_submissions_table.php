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
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->string('linkedin_url')->nullable()->after('phone');
            $table->string('website_url')->nullable()->after('linkedin_url');
            $table->decimal('lead_value', 12, 2)->default(0)->after('message');
            $table->string('temp_status')->default('new')->after('status');
        });

        // Migrate current status to temp_status if needed, then drop status and rename temp_status
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->enum('status', ['new', 'contacted', 'qualified', 'proposal_sent', 'won', 'lost'])->default('new')->after('user_agent');
            $table->dropColumn('temp_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn(['linkedin_url', 'website_url', 'lead_value']);
            $table->dropColumn('status');
        });
        
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->enum('status', ['new', 'read', 'replied'])->default('new')->after('user_agent');
        });
    }
};
