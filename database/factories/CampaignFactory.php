<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brief' => 'Byomkesh S9, dark & mysterious, from 10 Oct',
            'language' => 'bilingual',
            'title' => 'Byomkesh Season 9 Premiere',
            'instagram_caption' => 'The truth is stranger than fiction. Byomkesh Season 9 premieres October 10 on Hoichoi.',
            'instagram_hashtags' => ['#ByomkeshS9', '#Hoichoi', '#Satyanweshi'],
            'instagram_image_path' => 'generated-images/sample-ig.jpg',
            'youtube_title' => 'Byomkesh Season 9 | Official Teaser | Streaming 10 Oct | Hoichoi',
            'youtube_description' => 'The legendary detective returns to solve the darkest mystery yet.',
            'youtube_tags' => ['Byomkesh S9', 'Hoichoi', 'Bengali Thriller'],
            'youtube_image_path' => 'generated-images/sample-yt.jpg',
            'x_hook' => 'Where evidence ends, Satyanweshi begins. Byomkesh Season 9 streams from 10th Oct on @hoichoitv.',
            'x_hashtags' => ['#ByomkeshS9', '#Hoichoi'],
            'x_image_path' => 'generated-images/sample-x.jpg',
            'metadata' => ['provider' => 'cloudflare-flux'],
        ];
    }
}
