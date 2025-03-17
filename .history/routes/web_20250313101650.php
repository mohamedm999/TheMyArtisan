<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ArtisanController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Artisan\DashboardController as ArtisanDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use Illuminate\Support\Facades\Route;
use 

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Register
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Password Reset
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authentication Routes
Auth::routes();

// If you're not using Laravel's built-in Auth routes, add these:
// Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users management
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Artisans management
    Route::get('artisans', [ArtisanController::class, 'index'])->name('artisans.index');
    Route::get('artisans/{artisan}', [ArtisanController::class, 'show'])->name('artisans.show');
    Route::put('artisans/{artisan}/approve', [ArtisanController::class, 'approve'])->name('artisans.approve');
    Route::put('artisans/{artisan}/reject', [ArtisanController::class, 'reject'])->name('artisans.reject');

    // Services management
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Bookings management
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::put('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Categories management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
});

// Artisan routes
Route::prefix('artisan')->middleware(['auth', 'role:artisan'])->group(function () {
    Route::get('dashboard', [ArtisanDashboardController::class, 'index'])->name('artisan.dashboard');
    Route::get('/profile', [ArtisanDashboardController::class, 'profile'])->name('artisan.profile');
    Route::get('/services', [ArtisanDashboardController::class, 'services'])->name('artisan.services');
    Route::get('/bookings', [ArtisanDashboardController::class, 'bookings'])->name('artisan.bookings');
    Route::get('/schedule', [ArtisanDashboardController::class, 'schedule'])->name('artisan.schedule');
    Route::get('/reviews', [ArtisanDashboardController::class, 'reviews'])->name('artisan.reviews');
    Route::get('/messages', [ArtisanDashboardController::class, 'messages'])->name('artisan.messages');
    Route::get('/settings', [ArtisanDashboardController::class, 'settings'])->name('artisan.settings');
});

// Client routes
Route::prefix('client')->middleware(['auth', 'role:client'])->group(function () {
    Route::get('dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/profile', [ClientDashboardController::class, 'profile'])->name('client.profile');
    Route::get('/find-artisans', [ClientDashboardController::class, 'findArtisans'])->name('client.find-artisans');
    Route::get('/bookings', [ClientDashboardController::class, 'bookings'])->name('client.bookings');
    Route::get('/saved-artisans', [ClientDashboardController::class, 'savedArtisans'])->name('client.saved-artisans');
    Route::get('/messages', [ClientDashboardController::class, 'messages'])->name('client.messages');
    Route::get('/settings', [ClientDashboardController::class, 'settings'])->name('client.settings');
});
