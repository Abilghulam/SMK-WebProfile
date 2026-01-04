<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LegalDocumentController;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AdminPasswordResetController;

use App\Http\Controllers\admin\AdminHomeManagementController;
use App\Http\Controllers\Admin\AdminPostsController;
use App\Http\Controllers\Admin\AdminLegalDocumentsController;
use App\Http\Controllers\Admin\AdminGalleriesController;
use App\Http\Controllers\Admin\AdminGalleryItemsController;
use \App\Http\Controllers\Admin\AdminDepartmentsController;

// User Routes
Route::get('/', [HomeController::class, 'index']);

Route::prefix('akademik')->group(function () {

    // Program Keahlian
    Route::get('/program-keahlian', [DepartmentController::class, 'index'])
        ->name('departments.index');

    Route::get('/program-keahlian/{slug}', [DepartmentController::class, 'show'])
        ->name('departments.show');

    // Fasilitas
    Route::get('/fasilitas', [FacilityController::class, 'index'])
        ->name('facilities.index');
});

Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');

    Route::get('/berita', [BlogController::class, 'news'])->name('blog.news');
    Route::get('/agenda', [BlogController::class, 'agenda'])->name('blog.agenda');
    Route::get('/prestasi', [BlogController::class, 'achievements'])->name('blog.achievements');

    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');
});

Route::prefix('dokumentasi')->group(function () {

    // Landing dokumentasi (album)
    Route::get('/', [GalleryController::class, 'index'])
        ->name('documentation.index');

    // Detail album
    Route::get('/{slug}', [GalleryController::class, 'show'])
        ->name('documentation.show');

});

Route::get('/layanan', function () {
    return view('layouts.user-pages.services.index');
})->name('services.index');

Route::get('/layanan/legalitas', [LegalDocumentController::class, 'index'])
    ->name('legal.index');

Route::get('/layanan/legalitas/{slug}', [LegalDocumentController::class, 'show'])
    ->name('legal.show');

Route::get('/layanan/legalitas/{slug}/download', [\App\Http\Controllers\LegalDocumentController::class, 'download'])
    ->name('legal.download');

// Admin Routes
// Login
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->middleware('throttle:8,1')
    ->name('admin.login.submit');

// OTP
Route::get('/admin/otp', [AdminAuthController::class, 'showOtpForm'])->name('admin.otp.form');
Route::post('/admin/otp', [AdminAuthController::class, 'verifyOtp'])
    ->middleware('throttle:10,1') 
    ->name('admin.otp.verify');

// Resend OTP
Route::post('/admin/otp/resend', [AdminAuthController::class, 'resendOtp'])
    ->middleware('throttle:3,1') 
    ->name('admin.otp.resend');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin.otp', 'admin.access'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

         // HOME MANAGEMENT
        Route::get('/home', [AdminHomeManagementController::class, 'index'])->name('home.index');

        Route::get('/home/profile', [AdminHomeManagementController::class, 'editProfile'])->name('home.profile.edit');
        Route::put('/home/profile', [AdminHomeManagementController::class, 'updateProfile'])->name('home.profile.update');

        Route::get('/home/statistics', [AdminHomeManagementController::class, 'editStatistics'])->name('home.statistics.edit');
        Route::put('/home/statistics', [AdminHomeManagementController::class, 'updateStatistics'])->name('home.statistics.update');

        Route::get('/home/principal', [AdminHomeManagementController::class, 'editPrincipal'])->name('home.principal.edit');
        Route::put('/home/principal', [AdminHomeManagementController::class, 'updatePrincipal'])->name('home.principal.update');

        // POSTS
        Route::get('/posts', [AdminPostsController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [AdminPostsController::class, 'create'])->name('posts.create');
        Route::post('/posts', [AdminPostsController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [AdminPostsController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [AdminPostsController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [AdminPostsController::class, 'destroy'])->name('posts.destroy');

        // LEGAL DOCUMENT
        Route::resource('legal-documents', AdminLegalDocumentsController::class)
            ->except(['show']);

        // toggle publish cepat (opsional)
        Route::patch('legal-documents/{legal_document}/toggle-publish', [AdminLegalDocumentsController::class, 'togglePublish'])
            ->name('legal-documents.toggle-publish');
        
        // DOKUMENTASI (Galleries + Items)
        Route::prefix('documentation')->name('documentation.')->group(function () {
            // galleries (album)
            Route::get('/', [AdminGalleriesController::class, 'index'])->name('galleries.index');
            Route::get('/create', [AdminGalleriesController::class, 'create'])->name('galleries.create');
            Route::post('/', [AdminGalleriesController::class, 'store'])->name('galleries.store');
            Route::get('/{gallery}/edit', [AdminGalleriesController::class, 'edit'])->name('galleries.edit');
            Route::put('/{gallery}', [AdminGalleriesController::class, 'update'])->name('galleries.update');
            Route::delete('/{gallery}', [AdminGalleriesController::class, 'destroy'])->name('galleries.destroy');

            // toggle publish album
            Route::patch('/{gallery}/toggle-publish', [AdminGalleriesController::class, 'togglePublish'])
                ->name('galleries.toggle-publish');

            // items dalam album
            Route::get('/{gallery}/items', [AdminGalleryItemsController::class, 'index'])->name('items.index');
            Route::post('/{gallery}/items', [AdminGalleryItemsController::class, 'store'])->name('items.store');

            // item actions
            Route::patch('/items/{item}', [AdminGalleryItemsController::class, 'update'])->name('items.update');
            Route::delete('/items/{item}', [AdminGalleryItemsController::class, 'destroy'])->name('items.destroy');
        });

        // DEPARTMENTS
        Route::resource('departments', AdminDepartmentsController::class)
            ->except(['show']);

        Route::patch('departments/{department}/toggle-active', [AdminDepartmentsController::class, 'toggleActive'])
            ->name('departments.toggle-active');


});

// Role Super Admin Only
Route::get('/settings')
    ->middleware('super_admin')
    ->name('settings');

// Forgot password (request link)
Route::get('/admin/forgot-password', [AdminPasswordResetController::class, 'requestForm'])
    ->name('admin.password.request');
Route::post('/admin/forgot-password', [AdminPasswordResetController::class, 'sendResetLink'])
    ->name('admin.password.email');

// Reset password (form + submit)
Route::get('/admin/reset-password/{token}', [AdminPasswordResetController::class, 'resetForm'])
    ->name('admin.password.reset');
Route::post('/admin/reset-password', [AdminPasswordResetController::class, 'resetPassword'])
    ->name('admin.password.update');

