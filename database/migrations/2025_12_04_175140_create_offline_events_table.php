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
        Schema::create('offline_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->text('description')->nullable();

            // Tempat acara
            $table->string('location');
            $table->text('address')->nullable();

            // Waktu acara
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            // Harga tiket
            $table->bigInteger('price')->default(0);
            $table->boolean('is_free')->default(false);

            // Kapasitas peserta
            $table->integer('capacity')->nullable();

            // Banner / cover acara
            $table->string('banner')->nullable();

            // draft / published / closed
            $table->enum('status', ['draft', 'published', 'closed'])
                ->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_events');
    }
};
