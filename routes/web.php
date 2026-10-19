<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\IntegrationController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Pages\AboutPageController;
use App\Http\Controllers\Pages\ContactPageController;
use App\Http\Controllers\Pages\ExperiencePageController;
use App\Http\Controllers\Pages\IntegrationsPageController;
use App\Http\Controllers\Pages\ServicesPageController;
use App\Http\Controllers\Pages\SkillsPageController;
use App\Http\Controllers\Pages\WorkPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutPageController::class, 'index'])->name('about');
Route::get('/skills', [SkillsPageController::class, 'index'])->name('skills');
Route::get('/services', [ServicesPageController::class, 'index'])->name('services');
Route::get('/work', [WorkPageController::class, 'index'])->name('work');
Route::get('/work/{project:slug}', [WorkPageController::class, 'show'])->name('work.show');
Route::get('/experience', [ExperiencePageController::class, 'index'])->name('experience');
Route::get('/integrations', [IntegrationsPageController::class, 'index'])->name('integrations');
Route::get('/contact', [ContactPageController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:8,1');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', function () {
    return response("User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: ".route('sitemap')."\n", 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit')->middleware('throttle:8,1');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('skills', SkillController::class)->except(['show']);
    Route::resource('experiences', ExperienceController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('integrations', IntegrationController::class)->except(['show']);
    Route::resource('testimonials', TestimonialController::class)->except(['show']);

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::patch('/messages/{id}/status', [MessageController::class, 'updateStatus'])->name('messages.status');
    Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
