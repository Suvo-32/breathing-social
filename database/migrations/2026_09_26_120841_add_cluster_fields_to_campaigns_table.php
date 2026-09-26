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
            $table->string('publish_date')->nullable()->after('language');
            $table->string('tone')->nullable()->after('publish_date');
            $table->string('actor')->nullable()->after('tone');
            $table->string('image_mode')->default('unified')->after('actor');
            $table->string('status')->default('completed')->after('image_mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['publish_date', 'tone', 'actor', 'image_mode', 'status']);
        });
    }
};
