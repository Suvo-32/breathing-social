<?php

namespace Tests\Feature;

use App\Models\GeneratedImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageGenerationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_image_generator_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Gemini Nano Banana');
        $response->assertSee('Write your prompt and generate an image');
    }

    public function test_can_generate_demo_preview_image(): void
    {
        $prompt = 'A beautiful sunset over the mountains';

        $response = $this->postJson('/generate', [
            'prompt' => $prompt,
            'demo_mode' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Image generated successfully!',
            'data' => [
                'prompt' => $prompt,
            ],
        ]);

        $this->assertDatabaseHas('generated_images', [
            'prompt' => $prompt,
        ]);

        $image = GeneratedImage::first();
        $this->assertNotNull($image);
        Storage::disk('public')->assertExists($image->image_path);
    }

    public function test_validation_fails_for_empty_prompt(): void
    {
        $response = $this->postJson('/generate', [
            'prompt' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['prompt']);
    }

    public function test_can_generate_image_via_mocked_gemini_api(): void
    {
        $fakePngBase64 = base64_encode(
            "\x89PNG\r\n\x1a\n\x00\x00\x00\rIHDR\x00\x00\x00\x01\x00\x00\x00\x01\x08\x06\x00\x00\x00\x1f\x15c4\x00\x00\x00\rIDATx\x9cc`\x00\x00\x00\x02\x00\x01H\xaf\xa4q\x00\x00\x00\x00IEND\xaeB`\x82"
        );

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'inlineData' => [
                                        'mimeType' => 'image/png',
                                        'data' => $fakePngBase64,
                                    ],
                                ],
                            ],
                        ],
                        'finishReason' => 'STOP',
                    ],
                ],
            ], 200),
        ]);

        $prompt = 'A futuristic city skyline with flying cars';

        $response = $this->postJson('/generate', [
            'prompt' => $prompt,
            'aspect_ratio' => '1:1',
            'api_key' => 'fake-test-gemini-key',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'prompt' => $prompt,
            ],
        ]);

        $this->assertDatabaseHas('generated_images', [
            'prompt' => $prompt,
        ]);

        $image = GeneratedImage::where('prompt', $prompt)->first();
        $this->assertNotNull($image);
        Storage::disk('public')->assertExists($image->image_path);
    }

    public function test_returns_error_when_api_key_is_missing(): void
    {
        config(['services.gemini.api_key' => null]);

        $response = $this->postJson('/generate', [
            'prompt' => 'A cute cat wearing sunglasses',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_can_delete_generated_image(): void
    {
        $image = GeneratedImage::factory()->create();
        Storage::disk('public')->put($image->image_path, 'sample binary');

        $response = $this->deleteJson("/images/{$image->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('generated_images', [
            'id' => $image->id,
        ]);
        Storage::disk('public')->assertMissing($image->image_path);
    }
}
