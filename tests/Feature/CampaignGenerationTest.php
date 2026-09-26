<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CampaignGenerationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_campaign_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Hoichoi Social Studio');
        $response->assertSee('Enter Campaign Brief');
        $response->assertSee('Generate 3-Platform Campaign');
    }

    public function test_campaign_generation_validation_fails_for_empty_brief(): void
    {
        $response = $this->postJson('/campaign/generate', [
            'brief' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['brief']);
    }

    public function test_can_generate_complete_campaign_package(): void
    {
        $fakeBase64 = base64_encode('fake image binary content');

        Http::fake([
            // Mock Gemini Copywriting
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'title' => 'Byomkesh S9 Official Campaign',
                                        'instagram' => [
                                            'caption' => 'The truth returns this October! 🕵️‍♂️',
                                            'hashtags' => ['#ByomkeshS9', '#Hoichoi'],
                                            'image_prompt' => 'Dark detective portrait 1:1',
                                        ],
                                        'youtube' => [
                                            'title' => 'Byomkesh Season 9 | Official Teaser | Hoichoi',
                                            'description' => 'Streaming from 10 Oct exclusively on Hoichoi.',
                                            'tags' => ['Byomkesh', 'Hoichoi'],
                                            'image_prompt' => 'Cinematic thumbnail 16:9',
                                        ],
                                        'x' => [
                                            'hook' => 'Where evidence ends, Satyanweshi begins. 🔍',
                                            'hashtags' => ['#ByomkeshS9'],
                                            'image_prompt' => 'Widescreen teaser still 16:9',
                                        ],
                                    ]),
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),

            // Mock Cloudflare FLUX
            'https://api.cloudflare.com/*' => Http::response([
                'success' => true,
                'result' => [
                    'image' => $fakeBase64,
                ],
            ], 200),
        ]);

        $response = $this->postJson('/campaign/generate', [
            'brief' => 'Byomkesh S9, dark & mysterious, from 10 Oct',
            'language' => 'bilingual',
            'tone' => 'Dark & Mysterious',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'brief',
                'title',
                'instagram' => ['caption', 'hashtags', 'image_url'],
                'youtube' => ['title', 'description', 'tags', 'image_url'],
                'x' => ['hook', 'hashtags', 'image_url'],
            ],
        ]);

        $this->assertDatabaseHas('campaigns', [
            'brief' => 'Byomkesh S9, dark & mysterious, from 10 Oct',
            'title' => 'Byomkesh S9 Official Campaign',
        ]);
    }

    public function test_can_generate_campaign_with_unified_image_and_actor(): void
    {
        // 1x1 white pixel JPEG base64
        $pixelJpgBase64 = base64_encode(hex2bin('ffd8ffe000104a46494600010101004800480000ffdb004300080606070605080707070909080a0c140d0c0b0b0c1912130f141d1a1f1e1d1a1c1c20242e2720222c231c1c2837292c30313434341f27393d38323c2e333431ffc0000b080001000101011100ffda0008010100003f00bf8001ffd9'));

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'title' => 'Byomkesh S9 Unified',
                                        'master_image_prompt' => 'Master poster for Byomkesh S9',
                                        'instagram' => ['caption' => 'IG Caption', 'hashtags' => ['#IG'], 'image_prompt' => 'IG Prompt'],
                                        'youtube' => ['title' => 'YT Title', 'description' => 'YT Desc', 'tags' => ['YT'], 'image_prompt' => 'YT Prompt'],
                                        'x' => ['hook' => 'X Hook', 'hashtags' => ['#X'], 'image_prompt' => 'X Prompt'],
                                    ]),
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
            'https://api.cloudflare.com/*' => Http::response([
                'success' => true,
                'result' => [
                    'image' => $pixelJpgBase64,
                ],
            ], 200),
        ]);

        $response = $this->postJson('/campaign/generate', [
            'brief' => 'Promote Byomkesh S9',
            'language' => 'bilingual',
            'tone' => 'Dark & Mysterious',
            'image_mode' => 'unified',
            'actor' => 'Byomkesh Bakshi (Anirban Bhattacharya)',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'brief' => 'Promote Byomkesh S9',
                'title' => 'Byomkesh S9 Unified',
            ],
        ]);

        $this->assertDatabaseHas('campaigns', [
            'brief' => 'Promote Byomkesh S9',
            'title' => 'Byomkesh S9 Unified',
        ]);
    }

    public function test_can_delete_campaign(): void
    {
        $campaign = Campaign::factory()->create([
            'instagram_image_path' => 'generated-images/test-ig.jpg',
        ]);
        Storage::disk('public')->put('generated-images/test-ig.jpg', 'binary');

        $response = $this->deleteJson("/campaign/{$campaign->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('campaigns', [
            'id' => $campaign->id,
        ]);
        Storage::disk('public')->assertMissing('generated-images/test-ig.jpg');
    }

    public function test_campaign_studio_page_renders_successfully(): void
    {
        $campaign = Campaign::factory()->create([
            'brief' => 'Byomkesh detective thriller in Kolkata',
            'title' => 'Byomkesh S9 Studio Test',
        ]);

        $response = $this->get("/campaign/{$campaign->id}");

        $response->assertStatus(200);
        $response->assertSee('Social Studio');
        $response->assertSee('Instagram Post');
        $response->assertSee('YouTube Video');
        $response->assertSee('X (Twitter) Post');
        $response->assertSee('AI Marketing Copilot');
        $response->assertSee('Magic Polish All Platforms');
    }

    public function test_can_improve_campaign_copy_with_ai_without_generating_images(): void
    {
        $campaign = Campaign::factory()->create([
            'brief' => 'Launch of detective thriller Chhayamoy',
            'title' => 'Chhayamoy Original',
            'instagram_caption' => 'Original caption',
            'instagram_image_path' => 'generated-images/original-ig.jpg',
        ]);

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => json_encode([
                                        'title' => 'Chhayamoy: The 100-Year Secret',
                                        'instagram' => [
                                            'caption' => 'Updated darker suspenseful caption! 🕵️',
                                            'hashtags' => ['#Chhayamoy', '#HoichoiExclusive'],
                                        ],
                                        'youtube' => [
                                            'title' => 'Chhayamoy Official Teaser',
                                            'description' => 'Updated teaser description.',
                                            'tags' => ['Chhayamoy', 'Bengali Thriller'],
                                        ],
                                        'x' => [
                                            'hook' => 'Every old house hides seven secrets! 🏚️',
                                            'hashtags' => ['#Chhayamoy'],
                                        ],
                                    ]),
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson("/campaign/{$campaign->id}/improve", [
            'section' => 'instagram_caption',
            'instruction' => 'Make it darker and more suspenseful',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'instagram' => [
                    'caption' => 'Updated darker suspenseful caption! 🕵️',
                ],
            ],
        ]);

        $campaign->refresh();
        $this->assertEquals('Updated darker suspenseful caption! 🕵️', $campaign->instagram_caption);
        // Assert image was NOT touched or regenerated
        $this->assertEquals('generated-images/original-ig.jpg', $campaign->instagram_image_path);
    }

    public function test_can_update_campaign_copy_manually(): void
    {
        $campaign = Campaign::factory()->create([
            'title' => 'Initial Title',
            'instagram_caption' => 'Initial Caption',
        ]);

        $response = $this->putJson("/campaign/{$campaign->id}/copy", [
            'title' => 'Manually Edited Title',
            'instagram_caption' => 'Manually Edited Caption',
            'instagram_hashtags' => ['#NewTag1', '#NewTag2'],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $campaign->refresh();
        $this->assertEquals('Manually Edited Title', $campaign->title);
        $this->assertEquals('Manually Edited Caption', $campaign->instagram_caption);
        $this->assertEquals(['#NewTag1', '#NewTag2'], $campaign->instagram_hashtags);
    }

    public function test_can_schedule_post_and_shows_published_when_time_passed(): void
    {
        $campaign = Campaign::factory()->create();
        $pastTime = now()->subMinutes(15)->toIso8601String();

        $response = $this->postJson("/campaign/{$campaign->id}/schedule", [
            'platform' => 'instagram',
            'scheduled_at' => $pastTime,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'instagram' => [
                    'is_published' => true,
                    'publish_status' => [
                        'status' => 'published',
                        'is_published' => true,
                        'label' => 'Published',
                    ],
                ],
            ],
        ]);

        $campaign->refresh();
        $this->assertTrue($campaign->getPostPublishStatus('instagram')['is_published']);
        $this->assertEquals('published', $campaign->getPostPublishStatus('instagram')['status']);
    }

    public function test_post_shows_scheduled_when_time_is_in_future(): void
    {
        $campaign = Campaign::factory()->create();
        $futureTime = now()->addHours(3)->toIso8601String();

        $response = $this->postJson("/campaign/{$campaign->id}/schedule", [
            'platform' => 'youtube',
            'scheduled_at' => $futureTime,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'youtube' => [
                    'is_published' => false,
                    'publish_status' => [
                        'status' => 'scheduled',
                        'is_published' => false,
                        'label' => 'Scheduled',
                    ],
                ],
            ],
        ]);

        $campaign->refresh();
        $this->assertFalse($campaign->getPostPublishStatus('youtube')['is_published']);
        $this->assertEquals('scheduled', $campaign->getPostPublishStatus('youtube')['status']);
    }

    public function test_can_clear_schedule_and_returns_unscheduled(): void
    {
        $campaign = Campaign::factory()->create([
            'x_scheduled_at' => now()->addDay(),
        ]);

        $this->assertEquals('scheduled', $campaign->getPostPublishStatus('x')['status']);

        $response = $this->postJson("/campaign/{$campaign->id}/schedule", [
            'platform' => 'x',
            'scheduled_at' => null,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'x' => [
                    'publish_status' => [
                        'status' => 'unscheduled',
                        'is_published' => false,
                        'label' => 'Unscheduled',
                    ],
                ],
            ],
        ]);

        $campaign->refresh();
        $this->assertNull($campaign->x_scheduled_at);
        $this->assertEquals('unscheduled', $campaign->getPostPublishStatus('x')['status']);
    }
}
