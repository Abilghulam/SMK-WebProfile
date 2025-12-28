<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LegalDocumentController;

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


