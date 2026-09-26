<?php

namespace App\Models;

use Database\Factories\CampaignFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    /** @use HasFactory<CampaignFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'brief',
        'language',
        'title',
        'instagram_caption',
        'instagram_hashtags',
        'instagram_image_path',
        'youtube_title',
        'youtube_description',
        'youtube_tags',
        'youtube_image_path',
        'x_hook',
        'x_hashtags',
        'x_image_path',
        'metadata',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'instagram_hashtags' => 'array',
            'youtube_tags' => 'array',
            'x_hashtags' => 'array',
            'metadata' => 'array',
        ];
    }

    /**
     * Public URLs for platform assets.
     */
    public function getInstagramImageUrlAttribute(): ?string
    {
        return $this->instagram_image_path ? asset('storage/'.$this->instagram_image_path) : null;
    }

    public function getYoutubeImageUrlAttribute(): ?string
    {
        return $this->youtube_image_path ? asset('storage/'.$this->youtube_image_path) : null;
    }

    public function getXImageUrlAttribute(): ?string
    {
        return $this->x_image_path ? asset('storage/'.$this->x_image_path) : null;
    }
}
