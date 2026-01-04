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
        Schema::create('ebook_downloads', function (Blueprint $table) {
            $table->id();

            // Relasi ke ebook
            $table->foreignId('ebook_id')->constrained('ebooks')->onDelete('cascade');

            // Data pengguna (bisa user terdaftar atau guest)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Data form
            $table->string('name');
            $table->string('email');
            $table->string('whatsapp');

            // Metadata
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_verified')->default(false); // Jika ingin verifikasi
            $table->timestamp('downloaded_at')->nullable();

            $table->timestamps();

            // Index untuk performa
            $table->index(['ebook_id', 'email']);
            $table->unique(['ebook_id', 'email']); // Cegah duplikat email per ebook
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_downloads');
    }
};