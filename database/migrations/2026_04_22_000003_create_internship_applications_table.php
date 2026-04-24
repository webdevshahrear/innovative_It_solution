<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->string('education');
            $table->string('current_status'); // student, job_holder, freelancer, other
            $table->foreignId('preferred_category_id')->constrained('internship_categories');
            $table->foreignId('secondary_category_id')->nullable()->constrained('internship_categories');
            $table->text('skills');
            $table->string('portfolio_url')->nullable();
            $table->string('cv_path')->nullable();
            $table->text('motivation');
            $table->string('available_hours'); // e.g. "4-6 hours/day"
            $table->boolean('has_laptop')->default(false);
            $table->boolean('has_internet')->default(false);
            $table->enum('status', [
                'pending', 'reviewed', 'terms_accepted',
                'exam_passed', 'exam_failed', 'paid', 'active', 'rejected'
            ])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
