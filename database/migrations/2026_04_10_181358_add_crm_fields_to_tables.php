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
            $table->timestamp('remind_at')->nullable()->after('status');
            $table->string('priority')->default('medium')->after('remind_at');
        });

        Schema::table('inquiry_notes', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('content');
            $table->string('file_name')->nullable()->after('file_path');
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('invoice_no')->unique();
            $table->decimal('amount', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->string('status')->default('pending'); // pending, paid, cancelled
            $table->date('due_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');

        Schema::table('inquiry_notes', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name']);
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn(['remind_at', 'priority']);
        });
    }
};
