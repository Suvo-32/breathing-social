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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->timestamp('instagram_scheduled_at')->nullable()->after('instagram_image_path');
            $table->timestamp('youtube_scheduled_at')->nullable()->after('youtube_image_path');
            $table->timestamp('x_scheduled_at')->nullable()->after('x_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['instagram_scheduled_at', 'youtube_scheduled_at', 'x_scheduled_at']);
        });
    }
};
