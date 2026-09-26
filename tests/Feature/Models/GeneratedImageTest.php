<?php

namespace Tests\Feature\Models;

use App\Models\GeneratedImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneratedImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_generated_image_via_factory(): void
    {
        $image = GeneratedImage::factory()->create([
            'prompt' => 'সুন্দরবনের বাঘ',
            'aspect_ratio' => '16:9',
        ]);

        $this->assertDatabaseHas('generated_images', [
            'id' => $image->id,
            'prompt' => 'সুন্দরবনের বাঘ',
            'aspect_ratio' => '16:9',
        ]);

        $this->assertNotEmpty($image->imageUrl);
    }
}
