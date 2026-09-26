<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ImageGenerationController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected Social Studio & Campaign Routes
Route::middleware('auth')->group(function (): void {
    Route::get('/', [CampaignController::class, 'index'])->name('campaign.index');
    Route::post('/campaign/generate', [CampaignController::class, 'generate'])->name('campaign.generate');
    Route::get('/campaign/{campaign}', [CampaignController::class, 'show'])->name('campaign.show');
    Route::post('/campaign/{campaign}/improve', [CampaignController::class, 'improve'])->name('campaign.improve');
    Route::put('/campaign/{campaign}/copy', [CampaignController::class, 'updateCopy'])->name('campaign.update-copy');
    Route::post('/campaign/{campaign}/schedule', [CampaignController::class, 'schedulePost'])->name('campaign.schedule-post');
    Route::delete('/campaign/{campaign}', [CampaignController::class, 'destroy'])->name('campaign.destroy');

    // Single Image Generator Routes
    Route::get('/single-image', [ImageGenerationController::class, 'index'])->name('image-generator.index');
    Route::post('/generate', [ImageGenerationController::class, 'generate'])->name('image-generator.generate');
    Route::delete('/images/{image}', [ImageGenerationController::class, 'destroy'])->name('image-generator.destroy');
});
