<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('application_id')->constrained('internship_applications')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('internship_categories');
            $table->foreignId('mentor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('registration_token')->unique()->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'suspended', 'completed', 'terminated'])->default('active');
            $table->decimal('performance_score', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('internship_notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posted_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->enum('target_audience', ['all', 'specific_category'])->default('all');
            $table->foreignId('target_category_id')->nullable()->constrained('internship_categories')->nullOnDelete();
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_notices');
        Schema::dropIfExists('internship_accounts');
    }
};
