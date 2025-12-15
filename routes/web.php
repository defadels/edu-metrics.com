<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikertScaleController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyCategoryController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyPublicController;
use Illuminate\Support\Facades\Route;

// In routes/web.php or a dedicated cache management route file
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear'); // Clear config cache as well
    Artisan::call('route:clear'); // Clear route cache
    Artisan::call('view:clear'); // Clear view cache
    Artisan::call('optimize:clear'); // Clear view cache

    return 'Cache cleared!';
});

// Public Routes (Surveys can be accessed without login)
Route::prefix('surveys')->name('surveys.')->group(function () {
    Route::get('/', [SurveyPublicController::class, 'index'])->name('index');
    Route::get('/{survey}', [SurveyPublicController::class, 'show'])->name('show');
    Route::get('/{survey}/start', [SurveyPublicController::class, 'start'])->name('start');
    Route::post('/{survey}/submit', [SurveyPublicController::class, 'submit'])->name('submit');
    Route::get('/{survey}/thank-you', [SurveyPublicController::class, 'thankYou'])->name('thank-you');
});

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    // Home Route (Protected)
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/welcome', function () {
        return redirect()->route('home');
    });

    // Dashboard Routes (Protected)
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::resource('categories', SurveyCategoryController::class);
        Route::resource('likert-scales', LikertScaleController::class);
        Route::resource('surveys', SurveyController::class);
        Route::resource('questions', QuestionController::class);
    });
});

// Auth Routes (from Breeze)
require __DIR__.'/auth.php';
