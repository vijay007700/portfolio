<?php

use App\Http\Controllers\Api\V1\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::get('/profile', [PortfolioController::class, 'profile'])->name('profile');
    Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.index');
    Route::get('/projects/{project:slug}', [PortfolioController::class, 'project'])->name('projects.show');
    Route::get('/skills', [PortfolioController::class, 'skills'])->name('skills');
    Route::get('/services', [PortfolioController::class, 'services'])->name('services');
    Route::get('/experience', [PortfolioController::class, 'experience'])->name('experience');
    Route::get('/integrations', [PortfolioController::class, 'integrations'])->name('integrations');
    Route::get('/testimonials', [PortfolioController::class, 'testimonials'])->name('testimonials');
    Route::post('/contact', [PortfolioController::class, 'contact'])->middleware('throttle:8,1')->name('contact');
});
