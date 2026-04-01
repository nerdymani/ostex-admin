<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\PortfolioController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\TestimonialController;
use App\Http\Controllers\Api\V1\StatsController;
use App\Http\Controllers\Api\V1\FaqController;
use App\Http\Controllers\Api\V1\PricingController;
use App\Http\Controllers\Api\V1\SettingsController;
use App\Http\Controllers\Api\V1\ContactController;

Route::get('/health', fn() => response()->json([
    'status'  => 'ok',
    'app'     => config('app.name'),
    'version' => 'v1',
    'time'    => now()->toIso8601String(),
]));

Route::prefix('v1')->group(function () {
    Route::get('/settings',              [SettingsController::class,    'index']);
    Route::get('/services',              [ServiceController::class,     'index']);
    Route::get('/services/categories',   [ServiceController::class,     'categories']);
    Route::get('/services/{slug}',       [ServiceController::class,     'show']);
    Route::get('/team',                  [TeamController::class,        'index']);
    Route::get('/team/{slug}',           [TeamController::class,        'show']);
    Route::get('/blog',                  [BlogController::class,        'index']);
    Route::get('/blog/categories',       [BlogController::class,        'categories']);
    Route::get('/blog/{slug}',           [BlogController::class,        'show']);
    Route::get('/portfolio',             [PortfolioController::class,   'index']);
    Route::get('/portfolio/categories',  [PortfolioController::class,   'categories']);
    Route::get('/portfolio/{slug}',      [PortfolioController::class,   'show']);
    Route::get('/gallery',               [GalleryController::class,     'index']);
    Route::get('/gallery/categories',    [GalleryController::class,     'categories']);
    Route::get('/testimonials',          [TestimonialController::class, 'index']);
    Route::get('/testimonials/featured', [TestimonialController::class, 'featured']);
    Route::get('/stats',                 [StatsController::class,       'index']);
    Route::get('/faqs',                  [FaqController::class,         'index']);
    Route::get('/faqs/{category}',       [FaqController::class,         'byCategory']);
    Route::get('/pricing',               [PricingController::class,     'index']);
    Route::post('/contact',              [ContactController::class,     'store']);
});
