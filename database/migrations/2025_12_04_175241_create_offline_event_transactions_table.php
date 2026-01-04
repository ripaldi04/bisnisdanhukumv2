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
        Schema::create('offline_event_transactions', function (Blueprint $table) {
            $table->id();
            // Relasi User & Event
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('offline_event_id')->constrained('offline_events')->onDelete('cascade');

            // Info transaksi
            $table->string('trx_id')->unique(); // Midtrans order ID
            $table->bigInteger('amount');       // Harga yang dibayar

            $table->string('status')->default('Pending');
            // Pending, Paid, Failed, Expired

            // Tiket
            $table->string('ticket_code')->unique(); // Untuk QR check-in
            $table->dateTime('checked_in_at')->nullable(); // Jika sudah hadir

            // Midtrans data
            $table->string('payment_type')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->dateTime('paid_at')->nullable();

            // Batas pembayaran
            $table->dateTime('payment_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_event_transactions');
    }
};
