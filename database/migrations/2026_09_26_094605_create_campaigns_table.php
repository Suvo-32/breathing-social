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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->text('brief');
            $table->string('language', 20)->default('bilingual');
            $table->string('title')->nullable();

            // Instagram Asset Fields
            $table->text('instagram_caption')->nullable();
            $table->json('instagram_hashtags')->nullable();
            $table->string('instagram_image_path')->nullable();

            // YouTube Asset Fields
            $table->string('youtube_title')->nullable();
            $table->text('youtube_description')->nullable();
            $table->json('youtube_tags')->nullable();
            $table->string('youtube_image_path')->nullable();

            // X (Twitter) Asset Fields
            $table->text('x_hook')->nullable();
            $table->json('x_hashtags')->nullable();
            $table->string('x_image_path')->nullable();

            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
