<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikertScaleController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyCategoryController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('categories', SurveyCategoryController::class);
    Route::resource('likert-scales', LikertScaleController::class);
    Route::resource('surveys', SurveyController::class);
    Route::resource('questions', QuestionController::class);
});
