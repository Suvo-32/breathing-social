<?php

namespace App\Services;

use App\Exceptions\GeminiApiException;
use App\Models\Campaign;
use App\Models\GeneratedImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignGeneratorService
{
    protected ?string $geminiApiKey;

    protected string $geminiBaseUrl;

    /**
     * Create a new service instance.
     */
    public function __construct(
        public GeminiImageService $imageService,
        public CastRosterService $castService = new CastRosterService
    ) {
        $this->geminiApiKey = config('services.gemini.api_key') ?: null;
        $this->geminiBaseUrl = config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta');
    }

    /**
     * Generate complete multi-platform campaign package from a single brief.
     *
     * @param  string  $brief  e.g. "Byomkesh S9, dark & mysterious, from 10 Oct"
     * @param  string  $language  'bilingual', 'bengali', 'english'
     * @param  string|null  $tone  optional creative tone
     * @param  string  $imageMode  'unified' (same hero image in 3 ratios) or 'distinct' (3 separate shots)
     * @param  string|null  $actor  optional actor/cast name from public/cast/
     *
     * @throws GeminiApiException
     */
    public function generateCampaign(
        string $brief,
        string $language = 'bilingual',
        ?string $tone = null,
        string $imageMode = 'unified',
        ?string $actor = null
    ): Campaign {
        // Allow adequate execution time for AI copywriting and image generation
        if (function_exists('set_time_limit')) {
            @set_time_limit(240);
        }

        $brief = trim($brief);
        if ($brief === '') {
            throw new GeminiApiException('Campaign brief cannot be empty.', 422);
        }

        // 1. Generate Platform-Specific Copy & Prompts via Gemini Flash
        $copyData = $this->generateCopywriting($brief, $language, $tone, $actor);

        $igPrompt = $copyData['instagram']['image_prompt'] ?? "Cinematic dark detective thriller poster for {$brief}, dramatic lighting, 8k";
        $ytPrompt = $copyData['youtube']['image_prompt'] ?? "Dramatic thriller YouTube video thumbnail for {$brief}, high contrast, 16:9 cinematic shot";
        $xPrompt = $copyData['x']['image_prompt'] ?? "Widescreen teaser visual for {$brief}, atmospheric mystery, 16:9";
        $masterPrompt = $copyData['master_image_prompt'] ?? $igPrompt;

        // 2. Generate Images based on selected mode
        if ($imageMode === 'distinct') {
            // Distinct Mode: 3 separate AI visual generations
            $igImage = $this->generatePlatformVisual($igPrompt, '1:1');
            $ytImage = $this->generatePlatformVisual($ytPrompt, '16:9');
            $xImage = $this->generatePlatformVisual($xPrompt, '16:9');
        } else {
            // Unified Mode (Default): 1 Master Hero Visual adapted to 1:1, 16:9, etc.
            $masterImage = $this->generatePlatformVisual($masterPrompt, '1:1');

            if ($masterImage) {
                // 1:1 Square for Instagram Post
                $igImage = $masterImage;

                // 16:9 Cinematic Landscape for YouTube Thumbnail
                $ytImage = $this->cropToAspect($masterImage, 16, 9, 'yt_16_9');

                // 16:9 Landscape for X Banner
                $xImage = $ytImage ?: $masterImage;
            } else {
                $igImage = null;
                $ytImage = null;
                $xImage = null;
            }
        }

        // 3. Save Campaign to Database
        $title = ! empty($copyData['title'])
            ? trim((string) $copyData['title'])
            : 'OTT Campaign: '.Str::limit(preg_replace('/\s+/', ' ', $brief), 60);

        return Campaign::create([
            'brief' => $brief,
            'language' => $language,
            'title' => $title,
            'instagram_caption' => $copyData['instagram']['caption'] ?? '',
            'instagram_hashtags' => $copyData['instagram']['hashtags'] ?? [],
            'instagram_image_path' => $igImage?->image_path,
            'youtube_title' => $copyData['youtube']['title'] ?? '',
            'youtube_description' => $copyData['youtube']['description'] ?? '',
            'youtube_tags' => $copyData['youtube']['tags'] ?? [],
            'youtube_image_path' => $ytImage?->image_path,
            'x_hook' => $copyData['x']['hook'] ?? '',
            'x_hashtags' => $copyData['x']['hashtags'] ?? [],
            'x_image_path' => $xImage?->image_path,
            'metadata' => [
                'tone' => $tone,
                'image_mode' => $imageMode,
                'actor' => $actor,
                'generated_at' => now()->toIso8601String(),
                'image_prompts' => [
                    'master' => $masterPrompt,
                    'instagram' => $igPrompt,
                    'youtube' => $ytPrompt,
                    'x' => $xPrompt,
                ],
            ],
        ]);
    }

    /**
     * Crop an existing GeneratedImage to a target aspect ratio using GD.
     */
    public function cropToAspect(GeneratedImage $sourceImage, int $targetRatioW, int $targetRatioH, string $suffix = '16_9'): ?GeneratedImage
    {
        if (! Storage::disk('public')->exists($sourceImage->image_path)) {
            return $sourceImage;
        }

        $binary = Storage::disk('public')->get($sourceImage->image_path);
        $sourceResource = @imagecreatefromstring($binary);
        if (! $sourceResource) {
            return $sourceImage;
        }

        $srcW = imagesx($sourceResource);
        $srcH = imagesy($sourceResource);

        $targetRatio = $targetRatioW / $targetRatioH;
        $currentRatio = $srcW / $srcH;

        if ($currentRatio > $targetRatio) {
            // Source is wider than target: crop width
            $cropH = $srcH;
            $cropW = (int) round($srcH * $targetRatio);
            $cropX = (int) round(($srcW - $cropW) / 2);
            $cropY = 0;
        } else {
            // Source is taller than target: crop height
            $cropW = $srcW;
            $cropH = (int) round($srcW / $targetRatio);
            $cropX = 0;
            // Bias crop slightly toward upper third (faces sit in upper 35%)
            $diffY = $srcH - $cropH;
            $cropY = (int) round($diffY * 0.35);
        }

        $cropped = imagecrop($sourceResource, [
            'x' => max(0, $cropX),
            'y' => max(0, $cropY),
            'width' => min($srcW, $cropW),
            'height' => min($srcH, $cropH),
        ]);

        imagedestroy($sourceResource);

        if (! $cropped) {
            return $sourceImage;
        }

        ob_start();
        imagejpeg($cropped, null, 92);
        $croppedBinary = (string) ob_get_clean();
        imagedestroy($cropped);

        $uuid = (string) Str::uuid();
        $relativePath = 'generated-images/'.$uuid.'_'.$suffix.'.jpg';
        Storage::disk('public')->put($relativePath, $croppedBinary);

        return GeneratedImage::create([
            'prompt' => $sourceImage->prompt." ({$targetRatioW}:{$targetRatioH} adapted)",
            'translated_prompt' => $sourceImage->translated_prompt,
            'aspect_ratio' => "{$targetRatioW}:{$targetRatioH}",
            'image_path' => $relativePath,
            'status' => 'completed',
        ]);
    }

    /**
     * Generate copy package for Instagram, YouTube, and X using Gemini.
     *
     * @return array<string, mixed>
     */
    protected function generateCopywriting(string $brief, string $language, ?string $tone, ?string $actor = null): array
    {
        $langInstruction = match ($language) {
            'bengali' => 'Write all captions, hooks, and descriptions strictly in authentic, engaging Bengali (বাংলা).',
            'english' => 'Write all captions, hooks, and descriptions in crisp, high-impact English.',
            default => 'Write in bilingual style (mix of catchy Bengali and English / Banglish) perfect for West Bengal and Indian OTT audiences.',
        };

        $toneInstruction = $tone ? "Creative tone: {$tone}." : 'Creative tone: Suspenseful, high-energy, premium OTT thriller.';

        $actorInstruction = '';
        if ($actor && trim($actor) !== '') {
            $enhancement = $this->castService->getActorPromptEnhancement($actor);
            $actorInstruction = "Lead Actor/Cast Star: {$actor}. Visual Likeness Instructions: {$enhancement}";
        }

        $systemPrompt = <<<PROMPT
You are the Chief Social Media Marketing Director for Hoichoi, the premier Indian Bengali OTT entertainment platform.
Given a promotional campaign brief for an OTT show, web series, or film, generate a complete multi-platform campaign package.

{$langInstruction}
{$toneInstruction}
{$actorInstruction}

IMPORTANT: You MUST respond ONLY with a single valid JSON object, with no markdown code fences (no ```json, no ```), no introductory text, and no commentary.

Use this EXACT JSON schema:
{
  "title": "Short Campaign Title",
  "master_image_prompt": "Ultra-detailed master promotional poster visual in English for AI image generator featuring the lead subject with dramatic cinematic lighting, authentic OTT aesthetic, central hero composition, 8k resolution",
  "instagram": {
    "caption": "Compelling Instagram post caption with hook, emotional storytelling, emojis, premiere date, and call-to-action to stream on Hoichoi.",
    "hashtags": ["#Tag1", "#Tag2", "#Tag3", "#Tag4", "#Tag5"],
    "image_prompt": "Ultra-detailed visual prompt in English for 1:1 Instagram post"
  },
  "youtube": {
    "title": "High CTR, suspenseful YouTube video title with date and OTT platform branding",
    "description": "Engaging YouTube description with synopsis teaser, watch details, and hashtags.",
    "tags": ["Tag 1", "Tag 2", "Tag 3", "Tag 4", "Tag 5", "Tag 6"],
    "image_prompt": "Ultra-detailed visual prompt in English for 16:9 YouTube thumbnail"
  },
  "x": {
    "hook": "Punchy, viral tweet hook under 260 characters with call-to-action and emojis.",
    "hashtags": ["#Tag1", "#Tag2", "#Tag3"],
    "image_prompt": "Ultra-detailed visual prompt in English for 16:9 widescreen cinematic teaser still"
  }
}
PROMPT;

        if (empty($this->geminiApiKey)) {
            return $this->getMockCampaignCopy($brief);
        }

        try {
            $endpoint = rtrim($this->geminiBaseUrl, '/').'/models/gemini-3-flash-preview:generateContent';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $this->geminiApiKey,
            ])->timeout(30)->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt."\n\nCampaign Brief: ".$brief],
                        ],
                    ],
                ],
            ]);

            if ($response->successful()) {
                $raw = (string) $response->json('candidates.0.content.parts.0.text');
                $cleaned = preg_replace('/^```(?:json)?\s*/i', '', trim($raw));
                $cleaned = preg_replace('/\s*```$/', '', $cleaned);

                $data = json_decode($cleaned, true);
                if (is_array($data) && isset($data['instagram'], $data['youtube'], $data['x'])) {
                    return $data;
                }
            }
        } catch (\Throwable) {
            // Fall back to structured template
        }

        return $this->getMockCampaignCopy($brief);
    }

    /**
     * Safely generate a platform visual with error protection.
     */
    protected function generatePlatformVisual(string $prompt, string $aspectRatio): ?GeneratedImage
    {
        try {
            return $this->imageService->generate($prompt, $aspectRatio);
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Fallback template when AI copywriting is unavailable.
     *
     * @return array<string, mixed>
     */
    protected function getMockCampaignCopy(string $brief): array
    {
        $cleanBriefSummary = Str::limit(preg_replace('/\s+/', ' ', $brief), 60);

        return [
            'title' => 'Campaign: '.$cleanBriefSummary,
            'master_image_prompt' => "Cinematic dark detective thriller master poster for {$cleanBriefSummary}, dramatic lighting, 8k",
            'instagram' => [
                'caption' => "রহস্যের নতুন অধ্যায় শুরু হচ্ছে... 🕵️‍♂️🔥\n\n{$brief}\n\nচোখ রাখুন @hoichoitv পর্দায়। সত্যের সন্ধান কখনোই সহজ ছিল না!\n\n#ComingSoon #Hoichoi",
                'hashtags' => ['#HoichoiOriginals', '#BengaliOTT', '#WebSeries', '#ThrillerSeries', '#StreamNow'],
                'image_prompt' => "Cinematic dark detective thriller poster for {$cleanBriefSummary}, dramatic lighting, 8k",
            ],
            'youtube' => [
                'title' => "{$cleanBriefSummary} | Official Teaser | Streaming Soon on Hoichoi",
                'description' => "Get ready for an edge-of-the-seat thriller experience! {$brief}.\n\nSubscribe to Hoichoi for more updates.",
                'tags' => ['Hoichoi', 'Bengali Series', 'Official Teaser', 'New Release', 'Thriller'],
                'image_prompt' => "Dramatic thriller YouTube video thumbnail for {$cleanBriefSummary}, high contrast, 16:9 cinematic shot",
            ],
            'x' => [
                'hook' => "যেখানে সব প্রমাণ শেষ হয়, সেখানেই শুরু হয় আসল খেলা! 🔍\n\n{$cleanBriefSummary}.\n\nStreaming exclusively on @hoichoitv.",
                'hashtags' => ['#Hoichoi', '#BengaliThriller', '#NowStreaming'],
                'image_prompt' => "Widescreen teaser visual for {$cleanBriefSummary}, atmospheric mystery, 16:9",
            ],
        ];
    }
}
