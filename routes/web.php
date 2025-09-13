<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Interview routes
    Route::resource('interviews', InterviewController::class);
    
    // Submission routes
    Route::get('interviews/{interview}/submit', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('interviews/{interview}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    
    // Review routes
    Route::post('submissions/{submission}/review', [ReviewController::class, 'store'])->name('reviews.store');
});