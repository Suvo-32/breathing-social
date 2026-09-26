<?php

namespace Database\Seeders;

use App\Models\GeneratedImage;
use Illuminate\Database\Seeder;

class GeneratedImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneratedImage::factory()->count(3)->create();
    }
}
