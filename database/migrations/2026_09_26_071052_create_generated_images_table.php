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
        Schema::create('generated_images', function (Blueprint $table) {
            $table->id();
            $table->text('prompt');
            $table->text('enhanced_prompt')->nullable();
            $table->string('aspect_ratio', 10)->default('1:1');
            $table->string('model', 50)->default('gemini-2.5-flash-image');
            $table->string('image_path');
            $table->string('mime_type', 30)->default('image/png');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_images');
    }
};
