<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $igTags = (array) ($this->instagram_hashtags ?? []);
        $ytTags = (array) ($this->youtube_tags ?? []);
        $xTags = (array) ($this->x_hashtags ?? []);

        return [
            'id' => $this->id,
            'brief' => $this->brief,
            'language' => $this->language,
            'title' => $this->title,
            'instagram' => [
                'caption' => $this->instagram_caption,
                'hashtags' => $igTags,
                'hashtags_string' => implode(' ', $igTags),
                'image_url' => $this->instagramImageUrl,
            ],
            'youtube' => [
                'title' => $this->youtube_title,
                'description' => $this->youtube_description,
                'tags' => $ytTags,
                'tags_string' => implode(', ', $ytTags),
                'image_url' => $this->youtubeImageUrl,
            ],
            'x' => [
                'hook' => $this->x_hook,
                'hashtags' => $xTags,
                'hashtags_string' => implode(' ', $xTags),
                'image_url' => $this->xImageUrl,
            ],
            'created_at_human' => $this->created_at?->diffForHumans(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
