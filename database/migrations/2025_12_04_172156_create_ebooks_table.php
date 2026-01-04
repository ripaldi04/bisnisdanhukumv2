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
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            $table->string('cover_image')->nullable();
            $table->string('file_path'); // file PDF

            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->bigInteger('price')->default(0);
            $table->boolean('is_free')->default(false);

            $table->bigInteger('views')->default(0);
            $table->bigInteger('downloads')->default(0);

            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
