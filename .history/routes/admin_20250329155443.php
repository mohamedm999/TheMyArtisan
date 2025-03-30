<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ArtisanController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\SettingsController;

Route::middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);

    // Artisan Management
    Route::resource('artisans', ArtisanController::class);

    // Service Management
    Route::resource('services', ServiceController::class);

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Booking Management
    Route::resource('bookings', BookingController::class);

    // System Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
});
