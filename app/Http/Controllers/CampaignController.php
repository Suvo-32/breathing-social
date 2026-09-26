<?php

namespace App\Http\Controllers;

use App\Exceptions\GeminiApiException;
use App\Http\Requests\GenerateCampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\CampaignGeneratorService;
use App\Services\CastRosterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        public CampaignGeneratorService $campaignService
    ) {}

    /**
     * Display the Campaign Studio workspace.
     */
    public function index(Request $request): View|JsonResponse
    {
        $campaigns = Campaign::query()->latest()->get();
        $latestCampaign = null;
        $castMembers = (new CastRosterService)->getAvailableCast();

        if ($request->wantsJson() || $request->query('format') === 'json') {
            return response()->json([
                'success' => true,
                'data' => CampaignResource::collection($campaigns),
            ]);
        }

        return view('campaign-generator', compact('campaigns', 'latestCampaign', 'castMembers'));
    }

    /**
     * Show a single campaign in dedicated Studio view or JSON resource.
     */
    public function show(Request $request, Campaign $campaign): View|JsonResponse
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => new CampaignResource($campaign),
            ]);
        }

        return view('campaign-studio', compact('campaign'));
    }

    /**
     * Improve specific text copy and hashtags using AI without generating any images.
     */
    public function improve(Request $request, Campaign $campaign): JsonResponse
    {
        $validated = $request->validate([
            'section' => 'nullable|string|in:all,instagram,youtube,x,instagram_caption,instagram_hashtags,youtube_title,youtube_description,youtube_tags,x_hook,x_hashtags',
            'instruction' => 'nullable|string|max:500',
        ]);

        try {
            $updatedCampaign = $this->campaignService->improveCampaignCopy(
                campaign: $campaign,
                section: $validated['section'] ?? 'all',
                instruction: $validated['instruction'] ?? null
            );

            return response()->json([
                'success' => true,
                'message' => 'Campaign copy improved with AI successfully!',
                'data' => new CampaignResource($updatedCampaign),
            ]);
        } catch (\Throwable $t) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to improve campaign copy: '.$t->getMessage(),
            ], 500);
        }
    }

    /**
     * Save manual text and hashtag edits for a campaign.
     */
    public function updateCopy(Request $request, Campaign $campaign): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:1000',
            'instagram_caption' => 'nullable|string',
            'instagram_hashtags' => 'nullable|array',
            'instagram_hashtags.*' => 'string',
            'instagram_scheduled_at' => 'nullable|date',
            'youtube_title' => 'nullable|string|max:1000',
            'youtube_description' => 'nullable|string',
            'youtube_tags' => 'nullable|array',
            'youtube_tags.*' => 'string',
            'youtube_scheduled_at' => 'nullable|date',
            'x_hook' => 'nullable|string|max:500',
            'x_hashtags' => 'nullable|array',
            'x_hashtags.*' => 'string',
            'x_scheduled_at' => 'nullable|date',
        ]);

        $campaign->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Campaign copy saved successfully!',
            'data' => new CampaignResource($campaign->fresh()),
        ]);
    }

    /**
     * Schedule or immediately publish a specific platform post.
     */
    public function schedulePost(Request $request, Campaign $campaign): JsonResponse
    {
        $validated = $request->validate([
            'platform' => 'required|string|in:instagram,youtube,x,all',
            'scheduled_at' => 'nullable|date',
        ]);

        $platform = strtolower($validated['platform']);
        $scheduledAt = $validated['scheduled_at'] ?? null;

        $updates = [];
        if ($platform === 'all' || $platform === 'instagram') {
            $updates['instagram_scheduled_at'] = $scheduledAt;
        }
        if ($platform === 'all' || $platform === 'youtube') {
            $updates['youtube_scheduled_at'] = $scheduledAt;
        }
        if ($platform === 'all' || $platform === 'x') {
            $updates['x_scheduled_at'] = $scheduledAt;
        }

        $campaign->update($updates);

        $platformLabel = match ($platform) {
            'instagram' => 'Instagram',
            'youtube' => 'YouTube',
            'x' => 'X (Twitter)',
            default => 'All posts',
        };

        $fresh = $campaign->fresh();
        $isPassed = $scheduledAt ? now()->greaterThanOrEqualTo(Carbon::parse($scheduledAt)) : false;

        $statusMsg = $scheduledAt
            ? ($isPassed ? "{$platformLabel} marked as Published!" : "{$platformLabel} scheduled successfully!")
            : "{$platformLabel} schedule cleared.";

        return response()->json([
            'success' => true,
            'message' => $statusMsg,
            'data' => new CampaignResource($fresh),
        ]);
    }

    /**
     * Generate multi-platform social campaign from a single brief.
     */
    public function generate(GenerateCampaignRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $campaign = $this->campaignService->generateCampaign(
                brief: $validated['brief'],
                language: $validated['language'] ?? 'english',
                tone: $validated['tone'] ?? null,
                imageMode: $validated['image_mode'] ?? 'unified',
                actor: $validated['actor'] ?? null,
                publishDate: $validated['publish_date'] ?? null,
                scheduledAt: $validated['scheduled_at'] ?? null,
                instagramScheduledAt: $validated['instagram_scheduled_at'] ?? null,
                youtubeScheduledAt: $validated['youtube_scheduled_at'] ?? null,
                xScheduledAt: $validated['x_scheduled_at'] ?? null,
            );

            return response()->json([
                'success' => true,
                'message' => 'Campaign package generated successfully!',
                'data' => new CampaignResource($campaign),
            ]);
        } catch (GeminiApiException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() <= 599 ? $e->getCode() : 500);
        } catch (\Throwable $t) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate campaign: '.$t->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a campaign and its associated image files.
     */
    public function destroy(Campaign $campaign): JsonResponse
    {
        $paths = [
            $campaign->instagram_image_path,
            $campaign->youtube_image_path,
            $campaign->x_image_path,
        ];

        foreach ($paths as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $campaign->delete();

        return response()->json([
            'success' => true,
            'message' => 'Campaign deleted successfully.',
        ]);
    }
}
