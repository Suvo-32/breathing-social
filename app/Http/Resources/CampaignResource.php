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
            'publish_date' => $this->publish_date,
            'tone' => $this->tone,
            'actor' => $this->actor,
            'image_mode' => $this->image_mode,
            'status' => $this->status,
            'title' => $this->title,
            'instagram_image_url' => $this->instagramImageUrl,
            'youtube_image_url' => $this->youtubeImageUrl,
            'x_image_url' => $this->xImageUrl,
            'instagram_scheduled_at' => $this->instagram_scheduled_at?->toIso8601String(),
            'youtube_scheduled_at' => $this->youtube_scheduled_at?->toIso8601String(),
            'x_scheduled_at' => $this->x_scheduled_at?->toIso8601String(),
            'instagram' => [
                'caption' => $this->instagram_caption,
                'hashtags' => $igTags,
                'hashtags_string' => implode(' ', $igTags),
                'image_url' => $this->instagramImageUrl,
                'scheduled_at' => $this->instagram_scheduled_at?->toIso8601String(),
                'scheduled_at_formatted' => $this->instagram_scheduled_at?->format('M j, Y • g:i A'),
                'scheduled_at_input' => $this->instagram_scheduled_at?->format('Y-m-d\TH:i'),
                'is_published' => $this->instagram_scheduled_at ? now()->greaterThanOrEqualTo($this->instagram_scheduled_at) : false,
                'publish_status' => $this->getPostPublishStatus('instagram'),
            ],
            'youtube' => [
                'title' => $this->youtube_title,
                'description' => $this->youtube_description,
                'tags' => $ytTags,
                'tags_string' => implode(', ', $ytTags),
                'image_url' => $this->youtubeImageUrl,
                'scheduled_at' => $this->youtube_scheduled_at?->toIso8601String(),
                'scheduled_at_formatted' => $this->youtube_scheduled_at?->format('M j, Y • g:i A'),
                'scheduled_at_input' => $this->youtube_scheduled_at?->format('Y-m-d\TH:i'),
                'is_published' => $this->youtube_scheduled_at ? now()->greaterThanOrEqualTo($this->youtube_scheduled_at) : false,
                'publish_status' => $this->getPostPublishStatus('youtube'),
            ],
            'x' => [
                'hook' => $this->x_hook,
                'hashtags' => $xTags,
                'hashtags_string' => implode(' ', $xTags),
                'image_url' => $this->xImageUrl,
                'scheduled_at' => $this->x_scheduled_at?->toIso8601String(),
                'scheduled_at_formatted' => $this->x_scheduled_at?->format('M j, Y • g:i A'),
                'scheduled_at_input' => $this->x_scheduled_at?->format('Y-m-d\TH:i'),
                'is_published' => $this->x_scheduled_at ? now()->greaterThanOrEqualTo($this->x_scheduled_at) : false,
                'publish_status' => $this->getPostPublishStatus('x'),
            ],
            'created_at_human' => $this->created_at?->diffForHumans(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
