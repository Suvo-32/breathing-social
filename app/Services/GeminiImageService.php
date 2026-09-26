<?php

namespace App\Services;

use App\Exceptions\GeminiApiException;
use App\Models\GeneratedImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GeminiImageService
{
    protected ?string $apiKey;

    protected string $defaultModel;

    protected string $baseUrl;

    protected ?string $cloudflareAccountId;

    protected ?string $cloudflareApiToken;

    /**
     * Create a new service instance.
     */
    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key') ?: null;
        $this->defaultModel = config('services.gemini.model', 'gemini-2.5-flash-image');
        $this->baseUrl = config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta');

        $this->cloudflareAccountId = config('services.cloudflare.account_id') ?: null;
        $this->cloudflareApiToken = config('services.cloudflare.api_token') ?: null;
    }

    /**
     * Check if Cloudflare Workers AI is configured.
     */
    public function hasCloudflare(): bool
    {
        return ! empty(config('services.cloudflare.account_id')) && ! empty(config('services.cloudflare.api_token'));
    }

    /**
     * Check if an API key is configured.
     */
    public function hasApiKey(?string $customApiKey = null): bool
    {
        $key = $this->resolveApiKey($customApiKey);

        return ! empty($key) || $this->hasCloudflare();
    }

    /**
     * Resolve the effective API key.
     */
    public function resolveApiKey(?string $customApiKey = null): ?string
    {
        $trimmed = trim((string) $customApiKey);

        return $trimmed !== '' ? $trimmed : $this->apiKey;
    }

    /**
     * Generate an image from a prompt.
     *
     * @param  string  $prompt  The user prompt
     * @param  string  $aspectRatio  Aspect ratio (1:1, 16:9, 9:16, 4:3, 3:4)
     * @param  string|null  $customApiKey  Optional API key override
     * @param  string|null  $customModel  Optional model override
     * @param  bool  $isDemo  Whether to generate a demo preview placeholder
     *
     * @throws GeminiApiException
     */
    public function generate(
        string $prompt,
        string $aspectRatio = '1:1',
        ?string $customApiKey = null,
        ?string $customModel = null,
        bool $isDemo = false
    ): GeneratedImage {
        $prompt = trim($prompt);
        if ($prompt === '') {
            throw new GeminiApiException('Prompt cannot be empty.', 422);
        }

        $aspectRatio = $this->sanitizeAspectRatio($aspectRatio);
        $model = $customModel ?: $this->defaultModel;

        if ($isDemo) {
            return $this->createDemoImage($prompt, $aspectRatio, $model);
        }

        $apiKey = $this->resolveApiKey($customApiKey);

        if (empty($apiKey) && ! $this->hasCloudflare()) {
            throw new GeminiApiException(
                'AI credentials not found. Please set GEMINI_API_KEY or CLOUDFLARE_API_TOKEN in your .env file.',
                401
            );
        }

        // 1. Try Cloudflare Workers AI FLUX if configured (High Quality + Free Daily Quota)
        if ($this->hasCloudflare()) {
            $image = $this->generateWithCloudflareFlux($prompt, $aspectRatio);
            if ($image) {
                return $image;
            }
        }

        // 2. Try Google Gemini Nano Banana
        if (! empty($apiKey)) {
            return $this->callGeminiApi($prompt, $aspectRatio, $model, $apiKey);
        }

        // 3. Fallback to free AI generator
        return $this->generateWithFreeFallback($prompt, $aspectRatio);
    }

    /**
     * Generate image using Cloudflare Workers AI (FLUX.1-schnell).
     */
    public function generateWithCloudflareFlux(string $prompt, string $aspectRatio): ?GeneratedImage
    {
        if (! $this->hasCloudflare()) {
            return null;
        }

        // If the prompt is in Bengali, translate and enrich it with authentic cultural details using Gemini Flash
        $visualPrompt = $this->containsBengali($prompt)
            ? $this->translateBengaliPrompt($prompt)
            : $prompt;

        $url = "https://api.cloudflare.com/client/v4/accounts/{$this->cloudflareAccountId}/ai/run/@cf/black-forest-labs/flux-1-schnell";

        try {
            $response = Http::withToken($this->cloudflareApiToken)->timeout(60)->post($url, [
                'prompt' => $visualPrompt,
            ]);

            if ($response->successful()) {
                $base64 = $response->json('result.image');
                if (! empty($base64)) {
                    $binary = base64_decode($base64);
                    $filename = 'generated-images/'.Str::uuid().'.jpg';
                    $this->saveToPublicAndStorage($filename, $binary);

                    return GeneratedImage::create([
                        'prompt' => $prompt,
                        'enhanced_prompt' => $visualPrompt !== $prompt ? $visualPrompt : null,
                        'aspect_ratio' => $aspectRatio,
                        'model' => 'FLUX.1-schnell (Cloudflare Workers AI)',
                        'image_path' => $filename,
                        'mime_type' => 'image/jpeg',
                        'file_size' => strlen($binary),
                    ]);
                }
            }
        } catch (\Throwable) {
            // Silently fall back to next provider if Cloudflare has network issue
        }

        return null;
    }

    /**
     * Call the Google Gemini API to generate the image.
     *
     * @throws GeminiApiException
     */
    protected function callGeminiApi(
        string $prompt,
        string $aspectRatio,
        string $model,
        string $apiKey
    ): GeneratedImage {
        $endpoint = rtrim($this->baseUrl, '/')."/models/{$model}:generateContent";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'responseModalities' => ['IMAGE'],
                'imageConfig' => [
                    'aspectRatio' => $aspectRatio,
                ],
                'candidateCount' => 1,
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $apiKey,
            ])->timeout(90)->post($endpoint, $payload);

            if ($response->successful()) {
                $json = $response->json();
                $parts = $json['candidates'][0]['content']['parts'] ?? [];
                $base64Data = null;
                $mimeType = 'image/png';

                foreach ($parts as $part) {
                    if (! empty($part['inlineData']['data'])) {
                        $base64Data = $part['inlineData']['data'];
                        $mimeType = $part['inlineData']['mimeType'] ?? 'image/png';
                        break;
                    }
                }

                if (! $base64Data) {
                    $finishReason = $json['candidates'][0]['finishReason'] ?? 'UNKNOWN';
                    $blockReason = $json['promptFeedback']['blockReason'] ?? null;

                    if ($blockReason) {
                        throw new GeminiApiException("Image generation blocked by safety filters: {$blockReason}", 422);
                    }

                    throw new GeminiApiException("No image data returned from model (finish reason: {$finishReason}).", 502);
                }

                return $this->storeGeneratedImage($base64Data, $prompt, $aspectRatio, $model, $mimeType);
            }

            $status = $response->status();
            $errorData = $response->json('error') ?? [];
            $errorMessage = $errorData['message'] ?? $response->body();

            // Google AI Studio sets quota limit: 0 on Gemini image models for unbilled accounts.
            // If quota is 0 or 429, seamlessly fallback to free AI generation so the user gets an image!
            if ($status === 429 || str_contains($errorMessage, 'limit: 0') || str_contains(strtolower($errorMessage), 'quota exceeded')) {
                return $this->generateWithFreeFallback($prompt, $aspectRatio);
            }

            throw new GeminiApiException("Gemini API error [{$status}]: {$errorMessage}", $status);
        } catch (GeminiApiException $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw new GeminiApiException('Connection error: '.$t->getMessage(), 500, $t);
        }
    }

    /**
     * Fallback to free AI image generation when Google Gemini free tier quota is 0.
     */
    protected function generateWithFreeFallback(string $prompt, string $aspectRatio): GeneratedImage
    {
        [$width, $height] = match ($aspectRatio) {
            '16:9' => [1280, 720],
            '9:16' => [720, 1280],
            '4:3' => [1024, 768],
            '3:4' => [768, 1024],
            default => [1024, 1024],
        };

        // If the prompt contains Bengali, translate and enhance it using Gemini's free text model
        $enhancedPrompt = $this->containsBengali($prompt)
            ? $this->translateBengaliPrompt($prompt)
            : $prompt;

        $url = 'https://image.pollinations.ai/prompt/'.rawurlencode($enhancedPrompt)."?width={$width}&height={$height}&nologo=true&model=flux";

        $response = Http::timeout(60)->get($url);

        if ($response->successful() && strlen($response->body()) > 1000) {
            $binary = $response->body();

            // Auto-strip bottom watermark banner if present
            $src = @imagecreatefromstring($binary);
            if ($src) {
                $srcW = imagesx($src);
                $srcH = imagesy($src);
                // Crop bottom 36 pixels where pollinations.ai watermark is stamped
                $cropH = max(100, $srcH - 36);
                $cropped = imagecrop($src, ['x' => 0, 'y' => 0, 'width' => $srcW, 'height' => $cropH]);
                if ($cropped) {
                    ob_start();
                    imagejpeg($cropped, null, 92);
                    $cleanBinary = (string) ob_get_clean();
                    imagedestroy($cropped);
                    $binary = $cleanBinary;
                }
                imagedestroy($src);
            }

            $filename = 'generated-images/'.Str::uuid().'.jpg';
            $this->saveToPublicAndStorage($filename, $binary);

            return GeneratedImage::create([
                'prompt' => $prompt,
                'aspect_ratio' => $aspectRatio,
                'model' => 'gemini-nano-banana (free-fallback)',
                'image_path' => $filename,
                'mime_type' => 'image/jpeg',
                'file_size' => strlen($binary),
            ]);
        }

        throw new GeminiApiException('Image generation failed. Please try again.', 429);
    }

    /**
     * Helper to write to both public disk and physical public/campaign-images/ folder.
     */
    protected function saveToPublicAndStorage(string $filename, string $binary): void
    {
        Storage::disk('public')->put($filename, $binary);

        $publicDir = public_path('campaign-images');
        if (! file_exists($publicDir)) {
            @mkdir($publicDir, 0755, true);
        }
        @file_put_contents($publicDir.'/'.basename($filename), $binary);
    }

    /**
     * Store the base64 image to public storage disk and database.
     */
    protected function storeGeneratedImage(
        string $base64Data,
        string $prompt,
        string $aspectRatio,
        string $model,
        string $mimeType
    ): GeneratedImage {
        $binary = base64_decode($base64Data);
        $extension = $mimeType === 'image/jpeg' ? 'jpg' : 'png';
        $filename = 'generated-images/'.Str::uuid().'.'.$extension;

        $this->saveToPublicAndStorage($filename, $binary);

        return GeneratedImage::create([
            'prompt' => $prompt,
            'aspect_ratio' => $aspectRatio,
            'model' => $model,
            'image_path' => $filename,
            'mime_type' => $mimeType,
            'file_size' => strlen($binary),
        ]);
    }

    /**
     * Create a demo placeholder when testing without an API key.
     */
    protected function createDemoImage(
        string $prompt,
        string $aspectRatio,
        string $model
    ): GeneratedImage {
        $escapedPrompt = htmlspecialchars(mb_substr($prompt, 0, 90));
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="800" height="800" viewBox="0 0 800 800">
  <rect width="100%" height="100%" fill="#090d16"/>
  <circle cx="400" cy="400" r="280" fill="#1e293b" stroke="#334155" stroke-width="2"/>
  <text x="400" y="360" font-family="system-ui, sans-serif" font-size="64" text-anchor="middle">🍌</text>
  <text x="400" y="430" font-family="system-ui, sans-serif" font-size="20" font-weight="600" fill="#f8fafc" text-anchor="middle">Demo Preview</text>
  <text x="400" y="470" font-family="system-ui, sans-serif" font-size="14" fill="#94a3b8" text-anchor="middle">{$escapedPrompt}</text>
  <text x="400" y="520" font-family="system-ui, sans-serif" font-size="12" fill="#64748b" text-anchor="middle">Set GEMINI_API_KEY in .env for real AI generation</text>
</svg>
SVG;

        $filename = 'generated-images/demo-'.Str::uuid().'.svg';
        Storage::disk('public')->put($filename, $svg);

        return GeneratedImage::create([
            'prompt' => $prompt,
            'aspect_ratio' => $aspectRatio,
            'model' => $model.' (preview)',
            'image_path' => $filename,
            'mime_type' => 'image/svg+xml',
            'file_size' => strlen($svg),
        ]);
    }

    /**
     * Sanitize aspect ratio.
     */
    protected function sanitizeAspectRatio(string $ratio): string
    {
        $validRatios = ['1:1', '16:9', '9:16', '4:3', '3:4'];

        return in_array($ratio, $validRatios, true) ? $ratio : '1:1';
    }

    /**
     * Check if string contains Bengali Unicode characters.
     */
    public function containsBengali(string $text): bool
    {
        return (bool) preg_match('/[\x{0980}-\x{09FF}]/u', $text);
    }

    /**
     * Translate and enrich a Bengali prompt into a high-detail visual prompt using Gemini Flash.
     */
    public function translateBengaliPrompt(string $prompt, ?string $apiKey = null): string
    {
        $key = $this->resolveApiKey($apiKey);
        if (empty($key)) {
            return $prompt;
        }

        try {
            $model = config('services.gemini.text_model', 'gemini-3.8-flash');
            $endpoint = rtrim($this->baseUrl, '/')."/models/{$model}:generateContent";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $key,
            ])->timeout(15)->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => 'Translate and convert this Bengali prompt into a concise, vivid English photo prompt for an AI image generator preserving authentic West Bengal / Bengali cultural context (only return the prompt, no conversational filler or quotes): '.$prompt,
                            ],
                        ],
                    ],
                ],
            ]);

            if ($response->successful()) {
                $text = trim((string) $response->json('candidates.0.content.parts.0.text'));
                if ($text !== '') {
                    return $text;
                }
            }
        } catch (\Throwable) {
            // Silently fallback to original prompt on translation error
        }

        return $prompt;
    }
}
