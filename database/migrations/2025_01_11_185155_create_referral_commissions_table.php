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
        Schema::create('referral_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id') // User yang memiliki kode referral
                ->constrained('users')
                ->cascadeOnDelete(); // Hapus data ini jika user terkait dihapus
            $table->foreignId('referred_user_id') // User yang menggunakan kode referral
                ->constrained('users')
                ->cascadeOnDelete(); // Hapus data ini jika user terkait dihapus
            $table->unsignedInteger('amount'); // Komisi dalam rupiah
            $table->enum('status', ['Not Submitted', 'Pending', 'Success', 'Rejected'])->default('Not Submitted'); // Status pembayaran
            $table->string('nama_bank')->nullable(); // Informasi rekening user
            $table->string('nama_rekening')->nullable(); // Informasi rekening user
            $table->string('nomor_rekening')->nullable(); // Informasi rekening user
            $table->string('proof')->nullable(); // Bukti pembayaran admin
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_commissions');
    }
};
