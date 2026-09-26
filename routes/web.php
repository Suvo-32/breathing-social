<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ImageGenerationController;
use Illuminate\Support\Facades\Route;

// Multi-Platform OTT Social Media Campaign Generator (Main)
Route::get('/', [CampaignController::class, 'index'])->name('campaign.index');
Route::post('/campaign/generate', [CampaignController::class, 'generate'])->name('campaign.generate');
Route::delete('/campaign/{campaign}', [CampaignController::class, 'destroy'])->name('campaign.destroy');

// Single Image Generator Route
Route::get('/single-image', [ImageGenerationController::class, 'index'])->name('image-generator.index');
Route::post('/generate', [ImageGenerationController::class, 'generate'])->name('image-generator.generate');
Route::delete('/images/{image}', [ImageGenerationController::class, 'destroy'])->name('image-generator.destroy');
