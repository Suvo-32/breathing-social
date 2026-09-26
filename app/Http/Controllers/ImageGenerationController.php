<?php

namespace App\Http\Controllers;

use App\Exceptions\GeminiApiException;
use App\Http\Requests\GenerateImageRequest;
use App\Http\Resources\GeneratedImageResource;
use App\Models\GeneratedImage;
use App\Services\GeminiImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ImageGenerationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        public GeminiImageService $geminiService
    ) {}

    /**
     * Display the simple image generator interface.
     */
    public function index(): View
    {
        $latestImage = GeneratedImage::query()->latest()->first();
        $hasApiKey = $this->geminiService->hasApiKey();

        return view('image-generator', compact('latestImage', 'hasApiKey'));
    }

    /**
     * Generate an image from prompt.
     */
    public function generate(GenerateImageRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $prompt = $validated['prompt'];
        $aspectRatio = $validated['aspect_ratio'] ?? '1:1';
        $customApiKey = $validated['api_key'] ?? null;
        $customModel = $validated['model'] ?? null;
        $demoMode = (bool) $request->input('demo_mode', false);

        try {
            $generatedImage = $this->geminiService->generate(
                prompt: $prompt,
                aspectRatio: $aspectRatio,
                customApiKey: $customApiKey,
                customModel: $customModel,
                isDemo: $demoMode
            );

            return response()->json([
                'success' => true,
                'message' => 'Image generated successfully!',
                'data' => new GeneratedImageResource($generatedImage),
            ]);
        } catch (GeminiApiException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() <= 599 ? $e->getCode() : 500);
        } catch (\Throwable $t) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: '.$t->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a generated image.
     */
    public function destroy(GeneratedImage $image): JsonResponse
    {
        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
        ]);
    }
}
