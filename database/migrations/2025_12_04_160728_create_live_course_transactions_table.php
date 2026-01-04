<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('live_course_transactions', function (Blueprint $table) {
            $table->id();

            // Relasi ke user dan live course
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('live_course_id')->constrained('live_courses')->onDelete('cascade');

            // Payment info
            $table->string('trx_id')->unique();                // untuk midtrans order_id
            $table->bigInteger('amount');                      // nilai pembayaran
            $table->string('status')->default('Pending');      // Pending, Paid, Failed, Expired

            // Bukti pembayaran manual (opsional)
            $table->string('proof')->nullable();

            // Midtrans callback tracking
            $table->string('payment_type')->nullable();        // qris, bank_transfer, gopay, dll
            $table->string('midtrans_transaction_id')->nullable(); // transaction_id dari midtrans
            $table->dateTime('paid_at')->nullable();           // settlement time

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_course_transactions');
    }
};
