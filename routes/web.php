<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MyListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // My Listings (Owner CRUD)
    Route::prefix('my-listings')->name('my-listings.')->group(function () {
        Route::get('/', [MyListingController::class, 'index'])->name('index');
        Route::get('/create', [MyListingController::class, 'create'])->name('create');
        Route::post('/', [MyListingController::class, 'store'])->name('store');
        Route::get('/{listing:slug}/edit', [MyListingController::class, 'edit'])->name('edit');
        Route::put('/{listing:slug}', [MyListingController::class, 'update'])->name('update');
        Route::delete('/{listing:slug}', [MyListingController::class, 'destroy'])->name('destroy');
        Route::patch('/{listing:slug}/toggle-status', [MyListingController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/images/{image}', [MyListingController::class, 'deleteImage'])->name('delete-image');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Favorites
    Route::post('/favorites/{listing}', [ListingController::class, 'toggleFavorite'])->name('favorites.toggle');

    // Conversations & Messages
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::get('/listings/{listing:slug}/contact', [ConversationController::class, 'start'])->name('conversations.start');
    Route::post('/conversations/{conversation}/send', [ConversationController::class, 'sendMessage'])->name('conversations.send-message');
});
