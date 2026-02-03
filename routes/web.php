<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MyListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBannerController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/sellers/{user}', [SellerController::class, 'show'])->name('sellers.show');

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
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{listing}', [ListingController::class, 'toggleFavorite'])->name('favorites.toggle');

    // Conversations & Messages
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::get('/listings/{listing:slug}/contact', [ConversationController::class, 'start'])->name('conversations.start');
    Route::post('/conversations/{conversation}/send', [ConversationController::class, 'sendMessage'])->name('conversations.send-message');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Authentication
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Admin Protected Routes
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Category Management
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category:slug}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category:slug}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category:slug}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        // User Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Banner Management
        Route::resource('banners', AdminBannerController::class);
        Route::get('/banners-search-listings', [AdminBannerController::class, 'searchListings'])->name('banners.search-listings');
    });
});
