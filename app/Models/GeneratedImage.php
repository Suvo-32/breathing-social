<?php

namespace App\Models;

use Database\Factories\GeneratedImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedImage extends Model
{
    /** @use HasFactory<GeneratedImageFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'prompt',
        'enhanced_prompt',
        'aspect_ratio',
        'model',
        'image_path',
        'mime_type',
        'file_size',
        'is_favorite',
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
            'is_favorite' => 'boolean',
            'metadata' => 'array',
            'file_size' => 'integer',
        ];
    }

    /**
     * Get the public URL of the generated image.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/'.$this->image_path);
    }
}
