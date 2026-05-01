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
use App\Http\Controllers\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;

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
        
        // CRM & Inquiry Management
        Route::get('inquiries/insights', [\App\Http\Controllers\Admin\InquiryAnalyticsController::class, 'index'])->name('inquiries.insights');
        Route::get('inquiries/board', [\App\Http\Controllers\Admin\InquiryController::class, 'index'])->name('inquiries.board');
        
        Route::resource('inquiries', \App\Http\Controllers\Admin\InquiryController::class);
        Route::post('inquiries/{inquiry}/update-status', [\App\Http\Controllers\Admin\InquiryController::class, 'updateStatus'])->name('inquiries.update-status');
        Route::post('inquiries/{inquiry}/add-note', [\App\Http\Controllers\Admin\InquiryController::class, 'addNote'])->name('inquiries.add-note');
        Route::post('inquiries/{inquiry}/convert-client', [\App\Http\Controllers\Admin\InquiryController::class, 'convertToClient'])->name('inquiries.convert-client');
        Route::post('inquiries/{inquiry}/duplicate', [\App\Http\Controllers\Admin\InquiryController::class, 'duplicate'])->name('inquiries.duplicate');
        Route::post('inquiries/{inquiry}/set-reminder', [\App\Http\Controllers\Admin\InquiryController::class, 'setReminder'])->name('inquiries.set-reminder');
        Route::post('inquiries/{inquiry}/assign', [\App\Http\Controllers\Admin\InquiryController::class, 'assign'])->name('inquiries.assign');
        
        Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class);
        Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
        Route::get('invoices/{invoice}/print', [\App\Http\Controllers\Admin\InvoiceController::class, 'print'])->name('invoices.print');
        
        Route::resource('subscribers', \App\Http\Controllers\Admin\SubscriberController::class)->only(['index', 'update', 'destroy']);
        Route::resource('statistics', \App\Http\Controllers\Admin\StatisticController::class);
        Route::resource('work-flows', \App\Http\Controllers\Admin\WorkFlowController::class);
        Route::resource('achievements', AdminAchievementController::class);
        Route::resource('gallery-items', AdminGalleryController::class);

        
        // Duplication Routes
        Route::post('hero-slides/{hero_slide}/duplicate', [AdminHeroSlideController::class, 'duplicate'])->name('hero-slides.duplicate');
        Route::post('services/{service}/duplicate', [AdminServiceController::class, 'duplicate'])->name('services.duplicate');
        Route::post('projects/{project}/duplicate', [AdminProjectController::class, 'duplicate'])->name('projects.duplicate');
        Route::post('blog/{blog}/duplicate', [AdminBlogController::class, 'duplicate'])->name('blog.duplicate');
        Route::post('team/{team}/duplicate', [AdminTeamController::class, 'duplicate'])->name('team.duplicate');
        Route::post('testimonials/{testimonial}/duplicate', [AdminTestimonialController::class, 'duplicate'])->name('testimonials.duplicate');
        Route::post('work-flows/{work_flow}/duplicate', [\App\Http\Controllers\Admin\WorkFlowController::class, 'duplicate'])->name('work-flows.duplicate');


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

// ═══════════════════════════════════════════════════════════════
// INTERNSHIP MODULE ROUTES
// ═══════════════════════════════════════════════════════════════

use App\Http\Controllers\Internship\InternshipController;
use App\Http\Controllers\Internship\ExamController;
use App\Http\Controllers\Internship\ResultController;
use App\Http\Controllers\Internship\PaymentController as InternshipPaymentController;
use App\Http\Controllers\Internship\InternAuthController;
use App\Http\Controllers\Intern\DashboardController as InternDashboardController;
use App\Http\Controllers\Intern\TaskController as InternTaskController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Mentor\TaskController as MentorTaskController;
use App\Http\Controllers\Admin\Internship\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\Internship\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\Internship\ExamResultController as AdminExamResultController;
use App\Http\Controllers\Admin\Internship\PaymentController as AdminInternshipPaymentController;
use App\Http\Controllers\Admin\Internship\InternManagementController;
use App\Http\Controllers\Admin\Internship\NoticeController as AdminNoticeController;

// ── Public Internship Routes ──
Route::prefix('internship')->name('internship.')->group(function () {
    Route::get('/',                              [InternshipController::class, 'landing'])->name('landing');
    Route::get('/apply',                         [InternshipController::class, 'apply'])->name('apply');
    Route::post('/apply',                        [InternshipController::class, 'storeApplication'])->name('apply.store');
    Route::get('/terms/{application}',           [InternshipController::class, 'terms'])->name('terms');
    Route::post('/terms/{application}/accept',   [InternshipController::class, 'acceptTerms'])->name('terms.accept');

    // Exam
    Route::get('/exam/{attempt}',                [ExamController::class, 'show'])->name('exam');
    Route::post('/exam/{attempt}/submit',        [ExamController::class, 'submit'])->name('exam.submit');
    Route::post('/exam/{attempt}/terminate',     [ExamController::class, 'terminate'])->name('exam.terminate');

    // Result
    Route::get('/result/{attempt}',              [ResultController::class, 'show'])->name('result');

    // Payment
    Route::get('/payment/{attempt}',             [InternshipPaymentController::class, 'show'])->name('payment');
    Route::post('/payment/{attempt}/ssl',        [InternshipPaymentController::class, 'processSSL'])->name('payment.ssl');
    Route::post('/payment/{attempt}/bkash',      [InternshipPaymentController::class, 'processBkash'])->name('payment.bkash');
    Route::post('/payment/success',              [InternshipPaymentController::class, 'success'])->name('payment.success')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/payment/fail',                 [InternshipPaymentController::class, 'fail'])->name('payment.fail')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/payment/cancel',               [InternshipPaymentController::class, 'cancel'])->name('payment.cancel')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/payment/{attempt}/bkash-pending',[InternshipPaymentController::class, 'bkashPending'])->name('payment.bkash-pending');

    // Intern Login
    Route::get('/login',                         [InternAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',                        [InternAuthController::class, 'login'])->name('login.submit');

    // Account Creation (post-payment)
    Route::get('/register/{token}',              [InternAuthController::class, 'showRegister'])->name('register');
    Route::post('/register/{token}',             [InternAuthController::class, 'register'])->name('register.store');
});

// ── Intern Dashboard Routes ──
Route::prefix('intern')->name('intern.')->middleware(['auth', 'intern'])->group(function () {
    Route::get('/dashboard',                     [InternDashboardController::class, 'index'])->name('dashboard');
    Route::get('/tasks',                         [InternTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}',                  [InternTaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/submit',          [InternTaskController::class, 'submit'])->name('tasks.submit');
    
    // Additional Intern Routes
    Route::get('/profile',                       [InternDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile',                       [InternDashboardController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/certification',                 [InternDashboardController::class, 'certification'])->name('certification');
    Route::get('/certificate/download',          [InternDashboardController::class, 'certificateDownload'])->name('certificate.download');
});

// ── Mentor Panel Routes ──
Route::prefix('mentor')->name('mentor.')->middleware(['auth', 'mentor'])->group(function () {
    Route::get('/dashboard',                     [MentorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/tasks',                         [MentorTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create',                  [MentorTaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks',                        [MentorTaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}',                  [MentorTaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/review',          [MentorTaskController::class, 'review'])->name('tasks.review');
});

// ── Admin Internship Routes ──
Route::prefix('admin/internship')->name('admin.internship.')->middleware(['auth', 'verified'])->group(function () {
    // Applications
    Route::get('applications',                                   [AdminApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{application}',                     [AdminApplicationController::class, 'show'])->name('applications.show');
    Route::post('applications/{application}/status',             [AdminApplicationController::class, 'updateStatus'])->name('applications.status');

    // Questions
    Route::get('questions',                                      [AdminQuestionController::class, 'index'])->name('questions.index');
    Route::get('questions/create',                               [AdminQuestionController::class, 'create'])->name('questions.create');
    Route::post('questions',                                     [AdminQuestionController::class, 'store'])->name('questions.store');
    Route::get('questions/generate',                             [AdminQuestionController::class, 'generatePage'])->name('questions.generate');
    Route::post('questions/generate-ai',                         [AdminQuestionController::class, 'generateAI'])->name('questions.generate-ai');
    Route::get('questions/{question}/edit',                      [AdminQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('questions/{question}',                           [AdminQuestionController::class, 'update'])->name('questions.update');
    Route::delete('questions/{question}',                        [AdminQuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('questions/{question}/approve',                  [AdminQuestionController::class, 'approve'])->name('questions.approve');

    // Exam Results
    Route::get('exam-results',                                   [AdminExamResultController::class, 'index'])->name('exam-results.index');

    // Payments
    Route::get('payments',                                       [AdminInternshipPaymentController::class, 'index'])->name('payments.index');
    Route::post('payments/{payment}/verify',                     [AdminInternshipPaymentController::class, 'verify'])->name('payments.verify');

    // Interns
    Route::get('interns',                                        [InternManagementController::class, 'index'])->name('interns.index');
    Route::get('interns/{account}',                              [InternManagementController::class, 'show'])->name('interns.show');
    Route::post('interns/{account}/assign-mentor',               [InternManagementController::class, 'assignMentor'])->name('interns.assign-mentor');
    Route::post('interns/{account}/toggle-status',               [InternManagementController::class, 'toggleStatus'])->name('interns.toggle-status');
    Route::post('interns/{account}/issue-certificate',           [InternManagementController::class, 'issueCertificate'])->name('interns.issue-certificate');
    Route::get('interns/{account}/view-certificate',             [InternManagementController::class, 'viewCertificate'])->name('interns.view-certificate');

    // Notices
    Route::resource('notices', AdminNoticeController::class)->names([
        'index'   => 'notices.index',
        'create'  => 'notices.create',
        'store'   => 'notices.store',
        'edit'    => 'notices.edit',
        'update'  => 'notices.update',
        'destroy' => 'notices.destroy',
    ]);
});
