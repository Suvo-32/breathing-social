<?php

use App\Http\Controllers\ImageGenerationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ImageGenerationController::class, 'index'])->name('image-generator.index');
Route::post('/generate', [ImageGenerationController::class, 'generate'])->name('image-generator.generate');
Route::delete('/images/{image}', [ImageGenerationController::class, 'destroy'])->name('image-generator.destroy');
