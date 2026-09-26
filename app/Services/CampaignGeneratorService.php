<?php

namespace App\Services;

use App\Exceptions\GeminiApiException;
use App\Models\Campaign;
use App\Models\GeneratedImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignGeneratorService
{
    protected ?string $geminiApiKey;

    protected string $geminiBaseUrl;

    protected string $geminiTextModel;

    /**
     * Create a new service instance.
     */
    public function __construct(
        public GeminiImageService $imageService,
        public CastRosterService $castService = new CastRosterService
    ) {
        $this->geminiApiKey = config('services.gemini.api_key') ?: null;
        $this->geminiBaseUrl = config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta');
        $this->geminiTextModel = config('services.gemini.text_model', 'gemini-3.8-flash');
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
        string $language = 'english',
        ?string $tone = null,
        string $imageMode = 'unified',
        ?string $actor = null,
        ?string $publishDate = null,
        ?string $scheduledAt = null,
        ?string $instagramScheduledAt = null,
        ?string $youtubeScheduledAt = null,
        ?string $xScheduledAt = null
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
        $copyData = $this->generateCopywriting($brief, $language, $tone, $actor, $publishDate);

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
            'publish_date' => $publishDate,
            'tone' => $tone,
            'actor' => $actor,
            'image_mode' => $imageMode,
            'status' => 'completed',
            'title' => $title,
            'instagram_caption' => $copyData['instagram']['caption'] ?? '',
            'instagram_hashtags' => $copyData['instagram']['hashtags'] ?? [],
            'instagram_image_path' => $igImage?->image_path,
            'instagram_scheduled_at' => $instagramScheduledAt ?? $scheduledAt,
            'youtube_title' => $copyData['youtube']['title'] ?? '',
            'youtube_description' => $copyData['youtube']['description'] ?? '',
            'youtube_tags' => $copyData['youtube']['tags'] ?? [],
            'youtube_image_path' => $ytImage?->image_path,
            'youtube_scheduled_at' => $youtubeScheduledAt ?? $scheduledAt,
            'x_hook' => $copyData['x']['hook'] ?? '',
            'x_hashtags' => $copyData['x']['hashtags'] ?? [],
            'x_image_path' => $xImage?->image_path,
            'x_scheduled_at' => $xScheduledAt ?? $scheduledAt,
            'metadata' => [
                'tone' => $tone,
                'image_mode' => $imageMode,
                'actor' => $actor,
                'publish_date' => $publishDate,
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
        $filename = $uuid.'_'.$suffix.'.jpg';
        $relativePath = 'generated-images/'.$filename;
        Storage::disk('public')->put($relativePath, $croppedBinary);

        // Also physically write directly into public/campaign-images/ folder
        $publicDir = public_path('campaign-images');
        if (! file_exists($publicDir)) {
            @mkdir($publicDir, 0755, true);
        }
        @file_put_contents($publicDir.'/'.$filename, $croppedBinary);

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
    protected function generateCopywriting(string $brief, string $language, ?string $tone, ?string $actor = null, ?string $publishDate = null): array
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

        $dateInstruction = '';
        if ($publishDate && trim($publishDate) !== '') {
            $dateInstruction = "Official Premiere / Release Date: {$publishDate}. Prominently integrate this premiere date across all captions, video titles, and hooks.";
        }

        $systemPrompt = <<<PROMPT
You are the Chief Social Media Marketing Director for Hoichoi, the premier Indian Bengali OTT entertainment platform.
Given a promotional campaign brief for an OTT show, web series, or film, generate a complete multi-platform campaign package.

{$langInstruction}
{$toneInstruction}
{$actorInstruction}
{$dateInstruction}

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

        $raw = $this->callGeminiText($systemPrompt."\n\nCampaign Brief: ".$brief, jsonMode: true);
        if ($raw !== null) {
            $data = json_decode($raw, true);
            if (is_array($data) && isset($data['instagram'], $data['youtube'], $data['x'])) {
                return $data;
            }
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

    /**
     * Improve specific text and hashtags of an existing campaign using Gemini Flash without generating any images.
     *
     * @param  string  $section  'all'|'instagram'|'youtube'|'x'|'instagram_caption'|'instagram_hashtags'|'youtube_title'|'youtube_description'|'youtube_tags'|'x_hook'|'x_hashtags'
     */
    public function improveCampaignCopy(Campaign $campaign, string $section = 'all', ?string $instruction = null): Campaign
    {
        $langInstruction = match ($campaign->language) {
            'bengali' => 'Write all captions, hooks, and descriptions strictly in authentic, engaging Bengali (বাংলা).',
            'english' => 'Write all captions, hooks, and descriptions in crisp, high-impact English.',
            default => 'Write in bilingual style (mix of catchy Bengali and English / Banglish) perfect for West Bengal and Indian OTT audiences.',
        };

        $toneInstruction = $campaign->tone ? "Creative tone: {$campaign->tone}." : 'Creative tone: Suspenseful, high-energy, premium OTT thriller.';
        $actorInstruction = $campaign->actor ? "Lead Actor/Cast Star: {$campaign->actor}." : '';
        $dateInstruction = $campaign->publish_date ? "Premiere / Release Date: {$campaign->publish_date}." : '';

        $targetField = match ($section) {
            'youtube_description' => 'YouTube Video Description & Synopsis (Full narrative synopsis, drama, intrigue, release schedule, call-to-action)',
            'youtube_title' => 'YouTube Video Title (Catchy, high CTR title with series name and OTT branding)',
            'youtube_tags' => 'YouTube Search Tags and Keywords (Array of 5-8 trending search terms)',
            'instagram_caption' => 'Instagram Post Caption (Emotional hook, engaging storytelling, emojis, release info)',
            'instagram_hashtags' => 'Instagram Strategic Hashtags (Array of 5-8 trending campaign tags)',
            'x_hook' => 'X (Twitter) Viral Post Hook (Sharp, punchy tweet under 260 chars with emojis and urgency)',
            'x_hashtags' => 'X (Twitter) Strategic Hashtags (Array of 3-5 trending tags)',
            'instagram' => 'Instagram Complete Package (Caption & Hashtags)',
            'youtube' => 'YouTube Complete Package (Title, Description Synopsis, & Tags)',
            'x' => 'X (Twitter) Complete Package (Tweet Hook & Hashtags)',
            default => 'Complete Multi-Platform Campaign Package',
        };

        $customInstruction = $instruction
            ? "MANDATORY USER PROMPT / INSTRUCTION: \"{$instruction}\"\nYou MUST prioritize and fulfill this exact creative direction for the target field ({$targetField})."
            : 'Elevate the copy to maximize audience engagement, suspense, viral impact, and streaming numbers.';

        $currentData = json_encode([
            'title' => $campaign->title,
            'instagram' => [
                'caption' => $campaign->instagram_caption,
                'hashtags' => $campaign->instagram_hashtags,
            ],
            'youtube' => [
                'title' => $campaign->youtube_title,
                'description' => $campaign->youtube_description,
                'tags' => $campaign->youtube_tags,
            ],
            'x' => [
                'hook' => $campaign->x_hook,
                'hashtags' => $campaign->x_hashtags,
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $systemPrompt = <<<PROMPT
You are the Chief Social Media Marketing Director for Hoichoi OTT, the premier Indian Bengali streaming platform.
Your task is to REWRITE and DRAMATICALLY IMPROVE promotional social media copy for this campaign.
CRITICAL CONSTRAINT: Do NOT generate or suggest any image prompts. ONLY refine text copy, titles, descriptions, and hashtags.

CAMPAIGN BRIEF & CONTEXT:
- Show/Campaign Brief: {$campaign->brief}
- {$langInstruction}
- {$toneInstruction}
- {$actorInstruction}
- {$dateInstruction}

SPECIFIC REWRITE TARGET:
Target Field: {$targetField}

{$customInstruction}

CURRENT CAMPAIGN COPY:
{$currentData}

CRITICAL RULES:
1. Thoroughly apply the user's prompt to the target section. If target is 'youtube_description', write an evocative, cinematic synopsis (2-3 detailed paragraphs) with intense atmosphere, character stakes, plot intrigue, release call-to-action, and streaming on Hoichoi details.
2. Return ONLY a valid JSON object matching the exact schema below (no markdown, no code fences):
{
  "title": "Improved campaign title",
  "instagram": {
    "caption": "Polished Instagram post caption with hook, emotional storytelling, emojis, and call-to-action to watch on Hoichoi.",
    "hashtags": ["#Tag1", "#Tag2", "#Tag3", "#Tag4", "#Tag5"]
  },
  "youtube": {
    "title": "High CTR, suspenseful YouTube video title with date and OTT platform branding",
    "description": "Richly rewritten YouTube description strictly fulfilling user prompt",
    "tags": ["Tag1", "Tag2", "Tag3", "Tag4", "Tag5"]
  },
  "x": {
    "hook": "Punchy viral tweet hook under 260 characters with call-to-action and emojis",
    "hashtags": ["#Tag1", "#Tag2", "#Tag3"]
  }
}
PROMPT;

        $improved = null;
        $rawText = $this->callGeminiText($systemPrompt, jsonMode: true);

        if ($rawText !== null) {
            $decoded = json_decode($rawText, true);
            if (is_array($decoded)) {
                $improved = $decoded;
            }
        }

        if (! $improved) {
            $improved = $this->getMockCampaignCopy($campaign->brief);
            if ($instruction) {
                if (in_array($section, ['all', 'youtube', 'youtube_description'])) {
                    $improved['youtube']['description'] = "Get ready for an edge-of-the-seat experience! {$instruction}\n\n{$campaign->brief}\n\nStreaming exclusively on Hoichoi.";
                }
                if (in_array($section, ['all', 'instagram', 'instagram_caption'])) {
                    $improved['instagram']['caption'] = "🔥 {$instruction}\n\n{$campaign->brief}\n\nচোখ রাখুন @hoichoitv পর্দায়!\n\n#Hoichoi #StreamNow";
                }
                if (in_array($section, ['all', 'x', 'x_hook'])) {
                    $improved['x']['hook'] = "⚡ {$instruction} - {$campaign->brief} | Streaming on @hoichoitv";
                }
            }
        }

        // Apply changes to Campaign based on section without touching images!
        if (isset($improved['title']) && in_array($section, ['all', 'youtube', 'youtube_title'])) {
            $campaign->title = trim((string) $improved['title']);
        }

        if (in_array($section, ['all', 'instagram', 'instagram_caption'])) {
            $cap = $improved['instagram']['caption'] ?? $improved['instagram_caption'] ?? null;
            if ($cap !== null) {
                $campaign->instagram_caption = (string) $cap;
            }
        }

        if (in_array($section, ['all', 'instagram', 'instagram_hashtags'])) {
            $tags = $improved['instagram']['hashtags'] ?? $improved['instagram_hashtags'] ?? null;
            if (is_array($tags)) {
                $campaign->instagram_hashtags = $tags;
            }
        }

        if (in_array($section, ['all', 'youtube', 'youtube_title'])) {
            $title = $improved['youtube']['title'] ?? $improved['youtube_title'] ?? null;
            if ($title !== null) {
                $campaign->youtube_title = (string) $title;
            }
        }

        if (in_array($section, ['all', 'youtube', 'youtube_description'])) {
            $desc = $improved['youtube']['description'] ?? $improved['youtube_description'] ?? null;
            if ($desc !== null) {
                $campaign->youtube_description = (string) $desc;
            }
        }

        if (in_array($section, ['all', 'youtube', 'youtube_tags'])) {
            $tags = $improved['youtube']['tags'] ?? $improved['youtube_tags'] ?? null;
            if (is_array($tags)) {
                $campaign->youtube_tags = $tags;
            }
        }

        if (in_array($section, ['all', 'x', 'x_hook'])) {
            $hook = $improved['x']['hook'] ?? $improved['x_hook'] ?? null;
            if ($hook !== null) {
                $campaign->x_hook = (string) $hook;
            }
        }

        if (in_array($section, ['all', 'x', 'x_hashtags'])) {
            $tags = $improved['x']['hashtags'] ?? $improved['x_hashtags'] ?? null;
            if (is_array($tags)) {
                $campaign->x_hashtags = $tags;
            }
        }

        $campaign->save();

        return $campaign->fresh();
    }

    /**
     * Call Gemini text generation with automatic model fallback and JSON format.
     */
    protected function callGeminiText(string $prompt, bool $jsonMode = true): ?string
    {
        if (empty($this->geminiApiKey)) {
            return null;
        }

        $models = array_unique([
            $this->geminiTextModel,
            'gemini-3.8-flash',
            'gemini-flash-lite-latest',
            'gemini-3.7-flash',
        ]);

        foreach ($models as $model) {
            try {
                $endpoint = rtrim($this->geminiBaseUrl, '/')."/models/{$model}:generateContent";

                $payload = [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                ];

                if ($jsonMode) {
                    $payload['generationConfig'] = [
                        'responseMimeType' => 'application/json',
                        'temperature' => 0.7,
                    ];
                }

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'x-goog-api-key' => $this->geminiApiKey,
                ])->timeout(30)->post($endpoint, $payload);

                if ($response->successful()) {
                    $raw = (string) $response->json('candidates.0.content.parts.0.text');
                    $cleaned = preg_replace('/^```(?:json)?\s*/i', '', trim($raw));
                    $cleaned = preg_replace('/\s*```$/i', '', $cleaned);

                    if ($cleaned !== '') {
                        return $cleaned;
                    }
                } else {
                    Log::warning("Gemini model {$model} returned status {$response->status()}: ".Str::limit($response->body(), 200));
                }
            } catch (\Throwable $e) {
                Log::warning("Gemini model {$model} request failed: ".$e->getMessage());
            }
        }

        return null;
    }
}
