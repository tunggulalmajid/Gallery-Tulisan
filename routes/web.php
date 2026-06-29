<?php

use App\Http\Controllers\Admin\AuthorProfileController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\WritingController;
use App\Http\Controllers\Guest\AuthorController;
use App\Http\Controllers\Guest\CollectionController as GuestCollectionController;
use App\Http\Controllers\Guest\HomeController;
use Illuminate\Support\Facades\Route;

// ─── Guest Routes ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/penulis', [AuthorController::class, 'index'])->name('author');

Route::prefix('koleksi')->name('collections.')->group(function () {
    Route::get('/', [GuestCollectionController::class, 'index'])->name('index');
    Route::get('/{slug}', [GuestCollectionController::class, 'show'])->name('show');
    Route::get('/{collectionSlug}/{writingSlug}', [GuestCollectionController::class, 'showWriting'])->name('writing');
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Hero Section
    Route::get('/hero', [HeroSectionController::class, 'edit'])->name('hero.edit');
    Route::post('/hero', [HeroSectionController::class, 'update'])->name('hero.update');

    // Collections
    Route::resource('collections', AdminCollectionController::class)->except(['show']);

    // Writings
    Route::resource('writings', WritingController::class)->except(['show']);

    // Image upload for TipTap
    Route::post('/writings/upload-image', [WritingController::class, 'uploadImage'])
        ->name('writings.upload-image');

    // Author profile
    Route::get('/profile', [AuthorProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [AuthorProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
