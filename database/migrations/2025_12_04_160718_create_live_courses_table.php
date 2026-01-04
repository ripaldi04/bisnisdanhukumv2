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
        Schema::create('live_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // Zoom details
            $table->string('zoom_link')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();

            // Time
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            // Price
            $table->bigInteger('price')->default(0);
            $table->boolean('is_free')->default(false);
            $table->string('cover_image')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_courses');
    }
};
