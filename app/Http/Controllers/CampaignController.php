<?php

namespace App\Http\Controllers;

use App\Exceptions\GeminiApiException;
use App\Http\Requests\GenerateCampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\CampaignGeneratorService;
use App\Services\CastRosterService;
use Illuminate\Http\JsonResponse;
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
    public function index(): View
    {
        $campaigns = Campaign::query()->latest()->paginate(6);
        $latestCampaign = Campaign::query()->latest()->first();
        $castMembers = (new CastRosterService)->getAvailableCast();

        return view('campaign-generator', compact('campaigns', 'latestCampaign', 'castMembers'));
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
                language: $validated['language'] ?? 'bilingual',
                tone: $validated['tone'] ?? null,
                imageMode: $validated['image_mode'] ?? 'unified',
                actor: $validated['actor'] ?? null
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
