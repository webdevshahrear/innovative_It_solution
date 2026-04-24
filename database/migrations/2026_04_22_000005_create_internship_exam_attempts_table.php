<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('internship_applications')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('internship_categories');
            $table->string('session_token')->unique()->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->integer('total_questions')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->decimal('score_percentage', 5, 2)->default(0);
            $table->integer('tab_switch_count')->default(0);
            $table->enum('status', ['in_progress', 'passed', 'failed', 'terminated'])->default('in_progress');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_exam_attempts');
    }
};
