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
use App\Http\Controllers\Artisan\ArtisanProfileController;
use Illuminate\Support\Facades\Route;


// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Register - make sure both routes exist and are properly defined
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password Reset
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});


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
    Route::get('/services', [ArtisanDashboardController::class, 'services'])->name('artisan.services');
    Route::get('/bookings', [ArtisanDashboardController::class, 'bookings'])->name('artisan.bookings');
    Route::get('/schedule', [ArtisanDashboardController::class, 'schedule'])->name('artisan.schedule');
    Route::get('/reviews', [ArtisanDashboardController::class, 'reviews'])->name('artisan.reviews');
    Route::get('/messages', [ArtisanDashboardController::class, 'messages'])->name('artisan.messages');
    Route::get('/settings', [ArtisanDashboardController::class, 'settings'])->name('artisan.settings');

    // Services management
    Route::get('/services', [App\Http\Controllers\Artisan\ServiceController::class, 'index'])->name('artisan.services');
    Route::post('/services', [App\Http\Controllers\Artisan\ServiceController::class, 'store'])->name('artisan.services.store');
    Route::put('/services/{id}', [App\Http\Controllers\Artisan\ServiceController::class, 'update'])->name('artisan.services.update');
    Route::delete('/services/{id}', [App\Http\Controllers\Artisan\ServiceController::class, 'destroy'])->name('artisan.services.delete');

    // Schedule management routes - FIX: Update route names to include 'artisan.' prefix
    Route::get('/schedule', [App\Http\Controllers\Artisan\ScheduleController::class, 'index'])->name('artisan.schedule');
    Route::post('/schedule', [App\Http\Controllers\Artisan\ScheduleController::class, 'store'])->name('artisan.schedule.store');
    Route::delete('/schedule/{id}', [App\Http\Controllers\Artisan\ScheduleController::class, 'destroy'])->name('artisan.schedule.destroy');

    // Reviews management routes - FIX: Update route names to include 'artisan.' prefix
    Route::get('/reviews', [App\Http\Controllers\Artisan\ReviewsController::class, 'index'])->name('artisan.reviews');
    Route::post('/reviews/{id}/respond', [App\Http\Controllers\Artisan\ReviewsController::class, 'respond'])->name('artisan.reviews.respond');
    Route::post('/reviews/{id}/report', [App\Http\Controllers\Artisan\ReviewsController::class, 'report'])->name('artisan.reviews.report');
});

// Artisan Profile Routes - consolidated for clarity and to avoid duplicate routes
Route::middleware(['auth', 'role:artisan'])->group(function () {
    // Profile view and general updates
    Route::get('/artisan/profile', [ArtisanProfileController::class, 'index'])->name('artisan.profile');
    Route::post('/artisan/profile', [ArtisanProfileController::class, 'updateProfile'])->name('artisan.profile.update');

    // Profile sections
    Route::post('/artisan/profile/photo', [ArtisanProfileController::class, 'updatePhoto'])->name('artisan.profile.photo');
    Route::post('/artisan/profile/professional-info', [ArtisanProfileController::class, 'updateProfessionalInfo'])->name('artisan.profile.professional-info');
    Route::post('/artisan/profile/contact-info', [ArtisanProfileController::class, 'updateContactInfo'])->name('artisan.profile.contact-info');
    Route::post('/artisan/profile/business-info', [ArtisanProfileController::class, 'updateBusinessInfo'])->name('artisan.profile.business-info');

    // Work Experience - ensure we're using consistent naming and only one route
    Route::post('/artisan/profile/work-experience', [ArtisanProfileController::class, 'storeWorkExperience'])->name('artisan.profile.work-experience');
    Route::delete('/artisan/profile/work-experience/{id}', [ArtisanProfileController::class, 'deleteWorkExperience'])->name('artisan.profile.work-experience.delete');

    // Certification
    Route::post('/artisan/profile/certification', [ArtisanProfileController::class, 'storeCertification'])->name('artisan.profile.certification');
    Route::delete('/artisan/profile/certification/{id}', [ArtisanProfileController::class, 'deleteCertification'])->name('artisan.profile.certification.delete');
});

// Clean up redundant route declarations in Artisan Profile Routes section
Route::middleware(['auth', 'role:artisan'])->prefix('artisan')->name('artisan.')->group(function () {
    // Profile view and general info
    Route::get('/profile', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'index'])->name('profile');

    // Profile sections with correct method names
    Route::post('/profile/photo', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'updateProfilePhoto'])->name('profile.photo');
    Route::post('/profile/professional-info', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'updateProfessionalInfo'])->name('profile.professional-info');
    Route::post('/profile/work-experience', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'addWorkExperience'])->name('profile.work-experience');
    Route::post('/profile/certification', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'addCertification'])->name('profile.certification');
    Route::delete('/profile/certification/{id}', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'deleteCertification'])->name('profile.certification.delete');
    Route::post('/profile/contact-info', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'updateContactInfo'])->name('profile.contact-info');
    Route::post('/profile/business-info', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'updateBusinessInfo'])->name('profile.business-info');
});

// Client routes
Route::prefix('client')->name('client.')->middleware(['auth', 'role:client'])->group(function () {
    Route::get('dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ClientDashboardController::class, 'profile'])->name('profile');
    Route::get('/find-artisans', [App\Http\Controllers\Client\FindArtisansController::class, 'index'])->name('find-artisans');
    Route::get('/bookings', [ClientDashboardController::class, 'bookings'])->name('bookings');
    Route::get('/saved-artisans', [ClientDashboardController::class, 'savedArtisans'])->name('saved-artisans');
    Route::get('/messages', [ClientDashboardController::class, 'messages'])->name('messages');
    Route::get('/settings', [ClientDashboardController::class, 'settings'])->name('settings');

    // Client profile routes
    Route::get('/profile', [App\Http\Controllers\Client\ClientProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [App\Http\Controllers\Client\ClientProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update-photo', [App\Http\Controllers\Client\ClientProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::post('/profile/update-personal-info', [App\Http\Controllers\Client\ClientProfileController::class, 'updatePersonalInfo'])->name('profile.update-personal-info');
    Route::post('/profile/update-preferences', [App\Http\Controllers\Client\ClientProfileController::class, 'updatePreferences'])->name('profile.update-preferences');
});

Route::get('/api/artisans', [App\Http\Controllers\Client\FindArtisansController::class, 'getArtisans'])
    ->name('api.artisans');
Route::get('/artisans/{id}', [App\Http\Controllers\Client\FindArtisansController::class, 'show'])
    ->name('client.artisan-profile');
Route::post('/artisans/{id}/save', [App\Http\Controllers\Client\FindArtisansController::class, 'saveArtisan'])
    ->name('client.save-artisan')->middleware('auth');
