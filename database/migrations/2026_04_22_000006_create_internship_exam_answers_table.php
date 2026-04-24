<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('internship_exam_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('internship_exam_questions')->onDelete('cascade');
            $table->enum('selected_option', ['a', 'b', 'c', 'd'])->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('internship_tab_violations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('internship_exam_attempts')->onDelete('cascade');
            $table->enum('violation_type', ['tab_switch', 'blur', 'visibility_hidden', 'keyboard_shortcut']);
            $table->timestamp('occurred_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_tab_violations');
        Schema::dropIfExists('internship_exam_answers');
    }
};
