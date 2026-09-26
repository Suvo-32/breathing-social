<?php

namespace App\Models;

use App\Services\CastRosterService;
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
        'publish_date',
        'tone',
        'actor',
        'image_mode',
        'status',
        'title',
        'instagram_caption',
        'instagram_hashtags',
        'instagram_image_path',
        'instagram_scheduled_at',
        'youtube_title',
        'youtube_description',
        'youtube_tags',
        'youtube_image_path',
        'youtube_scheduled_at',
        'x_hook',
        'x_hashtags',
        'x_image_path',
        'x_scheduled_at',
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
            'instagram_scheduled_at' => 'datetime',
            'youtube_tags' => 'array',
            'youtube_scheduled_at' => 'datetime',
            'x_hashtags' => 'array',
            'x_scheduled_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    /**
     * Get real-time schedule and publish status for a platform post.
     *
     * @return array{
     *     status: 'published'|'scheduled'|'unscheduled',
     *     is_published: bool,
     *     label: string,
     *     scheduled_at: ?string,
     *     scheduled_at_formatted: ?string,
     *     scheduled_at_input: ?string,
     *     human_diff: ?string
     * }
     */
    public function getPostPublishStatus(string $platform): array
    {
        $field = match (strtolower($platform)) {
            'instagram', 'ig' => 'instagram_scheduled_at',
            'youtube', 'yt' => 'youtube_scheduled_at',
            'x', 'twitter' => 'x_scheduled_at',
            default => null,
        };

        if (! $field) {
            return [
                'status' => 'unscheduled',
                'is_published' => false,
                'label' => 'Unscheduled',
                'scheduled_at' => null,
                'scheduled_at_formatted' => null,
                'scheduled_at_input' => null,
                'human_diff' => null,
            ];
        }

        $scheduledAt = $this->{$field};

        if (! $scheduledAt) {
            return [
                'status' => 'unscheduled',
                'is_published' => false,
                'label' => 'Unscheduled',
                'scheduled_at' => null,
                'scheduled_at_formatted' => null,
                'scheduled_at_input' => null,
                'human_diff' => null,
            ];
        }

        $isPublished = now()->greaterThanOrEqualTo($scheduledAt);

        return [
            'status' => $isPublished ? 'published' : 'scheduled',
            'is_published' => $isPublished,
            'label' => $isPublished ? 'Published' : 'Scheduled',
            'scheduled_at' => $scheduledAt->toIso8601String(),
            'scheduled_at_formatted' => $scheduledAt->format('M j, Y • g:i A'),
            'scheduled_at_input' => $scheduledAt->format('Y-m-d\TH:i'),
            'human_diff' => $scheduledAt->diffForHumans(),
        ];
    }

    public function getInstagramStatusAttribute(): array
    {
        return $this->getPostPublishStatus('instagram');
    }

    public function getYoutubeStatusAttribute(): array
    {
        return $this->getPostPublishStatus('youtube');
    }

    public function getXStatusAttribute(): array
    {
        return $this->getPostPublishStatus('x');
    }

    /**
     * Public URLs for platform assets.
     */
    public function getInstagramImageUrlAttribute(): ?string
    {
        if (! $this->instagram_image_path) {
            return null;
        }

        $basename = basename($this->instagram_image_path);
        if (file_exists(public_path('campaign-images/'.$basename))) {
            return asset('campaign-images/'.$basename);
        }

        return asset('storage/'.$this->instagram_image_path);
    }

    public function getYoutubeImageUrlAttribute(): ?string
    {
        if (! $this->youtube_image_path) {
            return null;
        }

        $basename = basename($this->youtube_image_path);
        if (file_exists(public_path('campaign-images/'.$basename))) {
            return asset('campaign-images/'.$basename);
        }

        return asset('storage/'.$this->youtube_image_path);
    }

    public function getXImageUrlAttribute(): ?string
    {
        if (! $this->x_image_path) {
            return null;
        }

        $basename = basename($this->x_image_path);
        if (file_exists(public_path('campaign-images/'.$basename))) {
            return asset('campaign-images/'.$basename);
        }

        return asset('storage/'.$this->x_image_path);
    }

    public function getActorPhotoUrlAttribute(): ?string
    {
        if (empty($this->actor)) {
            return null;
        }

        $cast = (new CastRosterService)->getAvailableCast();
        foreach ($cast as $member) {
            if (str_contains(strtolower($this->actor), strtolower($member['name'])) || str_contains(strtolower($member['name']), strtolower($this->actor))) {
                return $member['image_url'];
            }
        }

        return null;
    }

    public function getCleanTitleAttribute(): string
    {
        $clean = preg_replace('/^(Campaign:\s*)+/i', '', (string) $this->title);
        $clean = preg_replace('/^Title:\s*/i', '', $clean);

        return trim($clean) ?: 'Hoichoi OTT Campaign';
    }
}
