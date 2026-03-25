<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TeamController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ProjectCategoryController as AdminProjectCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

// --- Frontend Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/team', [TeamController::class, 'index'])->name('team');
Route::get('/team/{id}', [TeamController::class, 'show'])->name('team.show');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// --- Legal & Support Routes ---
Route::get('/privacy-policy', [\App\Http\Controllers\LegalController::class, 'privacy'])->name('privacy');
Route::get('/terms-of-use', [\App\Http\Controllers\LegalController::class, 'terms'])->name('terms');
Route::get('/help-center', [\App\Http\Controllers\LegalController::class, 'help'])->name('help');
Route::get('/sitemap', [\App\Http\Controllers\LegalController::class, 'sitemap'])->name('sitemap');

// --- Authenticaton & Admin Routes ---

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Routes Group
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('projects', AdminProjectController::class);
        Route::resource('project-categories', AdminProjectCategoryController::class);
        Route::resource('services', AdminServiceController::class);
        Route::resource('blog', AdminBlogController::class);
        Route::resource('team', AdminTeamController::class);
        Route::resource('testimonials', AdminTestimonialController::class);
        Route::resource('hero-slides', AdminHeroSlideController::class);
        
        // New Admin Modules
        Route::resource('inquiries', \App\Http\Controllers\Admin\InquiryController::class)->only(['index', 'show', 'destroy']);
        Route::post('inquiries/{inquiry}/mark-read', [\App\Http\Controllers\Admin\InquiryController::class, 'markAsRead'])->name('inquiries.mark-read');
        Route::post('inquiries/{inquiry}/duplicate', [\App\Http\Controllers\Admin\InquiryController::class, 'duplicate'])->name('inquiries.duplicate');
        
        Route::resource('subscribers', \App\Http\Controllers\Admin\SubscriberController::class)->only(['index', 'update', 'destroy']);
        Route::resource('statistics', \App\Http\Controllers\Admin\StatisticController::class);
        
        // Duplication Routes
        Route::post('hero-slides/{hero_slide}/duplicate', [AdminHeroSlideController::class, 'duplicate'])->name('hero-slides.duplicate');
        Route::post('services/{service}/duplicate', [AdminServiceController::class, 'duplicate'])->name('services.duplicate');
        Route::post('projects/{project}/duplicate', [AdminProjectController::class, 'duplicate'])->name('projects.duplicate');
        Route::post('blog/{blog}/duplicate', [AdminBlogController::class, 'duplicate'])->name('blog.duplicate');
        Route::post('team/{team}/duplicate', [AdminTeamController::class, 'duplicate'])->name('team.duplicate');
        Route::post('testimonials/{testimonial}/duplicate', [AdminTestimonialController::class, 'duplicate'])->name('testimonials.duplicate');

        // Settings Routes
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
