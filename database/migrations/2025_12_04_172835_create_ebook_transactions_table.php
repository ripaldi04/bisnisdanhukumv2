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
        Schema::create('ebook_transactions', function (Blueprint $table) {
            $table->id();

            // Relasi user & ebook
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ebook_id')->constrained('ebooks')->onDelete('cascade');

            // Payment information
            $table->string('trx_id')->unique();        // order_id dari Midtrans
            $table->bigInteger('amount');              // harga ebook
            $table->string('status')->default('Pending'); // Pending, Paid, Failed

            // Midtrans details
            $table->string('payment_type')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->dateTime('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_transactions');
    }
};
