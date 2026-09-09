<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikertScaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyCategoryController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyPublicController;
use App\Http\Controllers\ScaleOptionController;
use App\Http\Controllers\SurveyResponseController;
use App\Http\Controllers\RespondentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Middleware\AccessForRoles;

// In routes/web.php or a dedicated cache management route file
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear'); // Clear config cache as well
    Artisan::call('route:clear'); // Clear route cache
    Artisan::call('view:clear'); // Clear view cache
    Artisan::call('optimize:clear'); // Clear view cache

    return 'Cache cleared!';
});

Route::get('/seeder', function (){
    Artisan::call('db:seed');
    return 'Database seeded!';
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
    $output = Artisan::output();

    if (str_contains($output, 'Nothing to migrate')) {
        return 'Tidak ada yang di Migrate';
    }

    return nl2br($output);
});

// Public Routes (Surveys can be accessed without login)
Route::prefix('surveys')->name('surveys.')->group(function () {
    Route::get('/', [SurveyPublicController::class, 'index'])->name('index');
    Route::get('/history', [SurveyPublicController::class, 'history'])->name('history');
    Route::get('/history/{response}', [SurveyPublicController::class, 'showHistory'])->name('history.show');
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
    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', AccessForRoles::class])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::resource('categories', SurveyCategoryController::class);
        Route::resource('likert-scales', LikertScaleController::class);
        Route::resource('surveys', SurveyController::class);
        Route::resource('questions', QuestionController::class);
        Route::resource('respondents', RespondentController::class)->only(['index', 'show']);
        Route::resource('users', UserController::class);
        
        Route::get('surveys/{survey}/responses', [SurveyResponseController::class, 'index'])->name('surveys.responses.index');
        Route::get('surveys/{survey}/responses/{response}', [SurveyResponseController::class, 'show'])->name('surveys.responses.show');

        Route::get('likert-scale/{likertScale}/scale-option', [ScaleOptionController::class, 'edit'])->name('scale-option.edit');
        Route::put('likert-scale/{likertScale}/scale-option', [ScaleOptionController::class, 'update'])->name('scale-option.update');
    });

    // Profile Routes (Protected)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth Routes (from Breeze)
require __DIR__.'/auth.php';
