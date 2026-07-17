<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Author\BookController as AuthorBookController;
use App\Http\Controllers\Author\ReviewController as AuthorReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Subscriber\ReviewController as SubscriberReviewController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', BookController::class)->only('index', 'show');

// Auth routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Reviews (nested under books) - requires auth now
    Route::resource('books.reviews', ReviewController::class)->only(['create', 'store']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::post('users/bulk', [AdminUserController::class, 'bulk'])->name('users.bulk');
        Route::post('books/bulk', [AdminBookController::class, 'bulk'])->name('books.bulk');
        Route::post('reviews/bulk', [AdminReviewController::class, 'bulk'])->name('reviews.bulk');
        Route::resource('users', AdminUserController::class)->except('show');
        Route::resource('books', AdminBookController::class)->except('show');
        Route::resource('reviews', AdminReviewController::class)->except(['create', 'store', 'show']);
    });

    // Author routes
    Route::prefix('author')->name('author.')->middleware('role:author')->group(function () {
        Route::post('books/bulk', [AuthorBookController::class, 'bulk'])->name('books.bulk');
        Route::resource('books', AuthorBookController::class)->except('show');
        Route::get('reviews', [AuthorReviewController::class, 'index'])->name('reviews.index');
    });

    // Subscriber routes
    Route::prefix('subscriber')->name('subscriber.')->middleware('role:subscriber')->group(function () {
        Route::post('reviews/bulk', [SubscriberReviewController::class, 'bulk'])->name('reviews.bulk');
        Route::resource('reviews', SubscriberReviewController::class)->except(['create', 'store', 'show']);
    });
});
