<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_account_id')->constrained('internship_accounts')->onDelete('cascade');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->timestamp('deadline')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', [
                'pending', 'in_progress', 'submitted', 'reviewed', 'approved', 'rejected'
            ])->default('pending');
            $table->text('mentor_feedback')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->text('resources')->nullable();
            $table->timestamps();
        });

        Schema::create('internship_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('internship_tasks')->onDelete('cascade');
            $table->text('submission_text');
            $table->json('file_paths')->nullable();
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();
        });

        Schema::create('internship_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_account_id')->constrained('internship_accounts')->onDelete('cascade');
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->string('category_name');
            $table->string('performance_grade')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamp('issued_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_certificates');
        Schema::dropIfExists('internship_task_submissions');
        Schema::dropIfExists('internship_tasks');
    }
};
