<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneratedImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'prompt' => $this->prompt,
            'enhanced_prompt' => $this->enhanced_prompt,
            'aspect_ratio' => $this->aspect_ratio,
            'model' => $this->model,
            'image_url' => $this->imageUrl,
            'mime_type' => $this->mime_type,
            'file_size' => $this->file_size,
            'file_size_formatted' => $this->formatBytes($this->file_size),
            'is_favorite' => (bool) $this->is_favorite,
            'created_at' => $this->created_at?->toIso8601String(),
            'created_at_human' => $this->created_at?->diffForHumans(),
            'metadata' => $this->metadata,
        ];
    }

    /**
     * Format bytes into a human-readable string.
     */
    protected function formatBytes(?int $bytes): string
    {
        if (! $bytes || $bytes <= 0) {
            return '0 KB';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = (int) floor(log($bytes, 1024));

        return round($bytes / pow(1024, $i), 1).' '.($units[$i] ?? 'KB');
    }
}
