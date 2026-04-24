<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('internship_applications')->onDelete('cascade');
            $table->foreignId('attempt_id')->constrained('internship_exam_attempts')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->default(1000);
            $table->string('currency')->default('BDT');
            $table->string('tran_id')->unique();
            $table->string('val_id')->nullable();
            $table->enum('payment_method', ['sslcommerz', 'bkash'])->default('sslcommerz');
            $table->enum('status', ['pending', 'success', 'failed', 'cancelled'])->default('pending');
            $table->json('gateway_response')->nullable();
            $table->string('bkash_number')->nullable();
            $table->string('bkash_transaction_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_payments');
    }
};
