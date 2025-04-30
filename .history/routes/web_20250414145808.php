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
use App\Http\Controllers\Client\ClientProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;

// Add this route outside of any group for client contact functionality
Route::post('/contact-artisan', function (Request $request) {
    // Store the contact message
    // For now, just redirect back with success message
    return redirect()->back()->with('success', 'Your message has been sent to the artisan.');
})->name('client.contact');

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blog', function () {
    return view('blog.index');
})->name('blog.index');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/featured-artisans', function () {
    return view('featured-artisans');
})->name('featured-artisans');

// Craft pages
Route::prefix('crafts')->name('crafts.')->group(function () {
    Route::get('/', function () {
        return view('crafts.index');
    })->name('index');

    Route::get('/zellige', function () {
        return view('crafts.zellige');
    })->name('zellige');

    Route::get('/carpets', function () {
        return view('crafts.carpets');
    })->name('carpets');

    Route::get('/leather', function () {
        return view('crafts.leather');
    })->name('leather');

    Route::get('/metalwork', function () {
        return view('crafts.metalwork');
    })->name('metalwork');

    Route::get('/pottery', function () {
        return view('crafts.pottery');
    })->name('pottery');

    Route::get('/woodwork', function () {
        return view('crafts.woodwork');
    })->name('woodwork');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Register
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
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users management
    Route::resource('users', UserController::class);

    // Store Products Management
    Route::prefix('store')->name('store.')->group(function () {
        Route::resource('products', \App\Http\Controllers\Admin\StoreProductController::class);
        Route::get('/orders', [\App\Http\Controllers\Admin\StoreProductController::class, 'orders'])->name('orders.index');
        Route::get('/orders/{id}', [\App\Http\Controllers\Admin\StoreProductController::class, 'orderShow'])->name('orders.show');
        Route::put('/orders/{id}/status', [\App\Http\Controllers\Admin\StoreProductController::class, 'updateOrderStatus'])->name('orders.update-status');
    });

    // Client Points Management
    Route::prefix('points')->name('points.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ClientPointsController::class, 'index'])->name('index');
        Route::get('/analytics', [\App\Http\Controllers\Admin\ClientPointsController::class, 'analytics'])->name('analytics');
        Route::get('/{id}', [\App\Http\Controllers\Admin\ClientPointsController::class, 'show'])->name('show');
        Route::post('/{id}/adjust', [\App\Http\Controllers\Admin\ClientPointsController::class, 'adjustPoints'])->name('adjust');
    });

    // Artisans management
    Route::get('/artisans', [ArtisanController::class, 'index'])->name('artisans.index');
    Route::get('/artisans/{artisan}', [ArtisanController::class, 'show'])->name('artisans.show');
    Route::put('/artisans/{artisan}/approve', [ArtisanController::class, 'approve'])->name('artisans.approve');
    Route::put('/artisans/{artisan}/reject', [ArtisanController::class, 'reject'])->name('artisans.reject');
    Route::get('/artisans/export', [ArtisanController::class, 'export'])->name('artisans.export');
    Route::get('/artisans/{artisan}/services', [ArtisanController::class, 'services'])->name('artisans.services');

    // Certifications management
    Route::resource('/certifications', \App\Http\Controllers\Admin\CertificationController::class);
    Route::put('/certifications/{id}/status', [\App\Http\Controllers\Admin\CertificationController::class, 'updateStatus'])->name('certifications.status');

    // Services management
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Bookings management
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Categories management
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class);

    // Reviews management
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'show'])->name('reviews.show');
    Route::put('/reviews/{id}/status', [\App\Http\Controllers\Admin\ReviewController::class, 'updateStatus'])->name('reviews.status');
});

// Artisan routes
Route::prefix('artisan')->name('artisan.')->middleware(['auth', 'role:artisan'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [ArtisanDashboardController::class, 'index'])->name('dashboard');

    // Profile management
    Route::get('/profile', [ArtisanProfileController::class, 'index'])->name('profile');
    Route::post('/profile/photo', [ArtisanProfileController::class, 'updateProfilePhoto'])->name('profile.photo');
    Route::post('/profile/professional-info', [ArtisanProfileController::class, 'updateProfessionalInfo'])->name('profile.professional-info');
    Route::post('/profile/work-experience', [ArtisanProfileController::class, 'addWorkExperience'])->name('profile.work-experience');
    Route::post('/profile/certification', [ArtisanProfileController::class, 'addCertification'])->name('profile.certification');
    Route::delete('/profile/certification/{id}', [ArtisanProfileController::class, 'deleteCertification'])->name('profile.certification.delete');
    Route::post('/profile/contact-info', [ArtisanProfileController::class, 'updateContactInfo'])->name('profile.contact-info');
    Route::post('/profile/business-info', [ArtisanProfileController::class, 'updateBusinessInfo'])->name('profile.business-info');
    Route::post('/profile/categories', [ArtisanProfileController::class, 'updateCategories'])->name('profile.categories');
    Route::get('/get-cities', [ArtisanProfileController::class, 'getCities'])->name('get-cities');

    // Services management
    Route::get('/services', [\App\Http\Controllers\Artisan\ServiceController::class, 'index'])->name('services');
    Route::post('/services', [\App\Http\Controllers\Artisan\ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{id}', [\App\Http\Controllers\Artisan\ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [\App\Http\Controllers\Artisan\ServiceController::class, 'destroy'])->name('services.delete');

    // Schedule management
    Route::get('/schedule', [\App\Http\Controllers\Artisan\ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule', [\App\Http\Controllers\Artisan\ScheduleController::class, 'store'])->name('schedule.store');
    Route::delete('/schedule/{id}', [\App\Http\Controllers\Artisan\ScheduleController::class, 'destroy'])->name('schedule.destroy');

    // Reviews management
    Route::get('/reviews', [\App\Http\Controllers\Artisan\ReviewsController::class, 'index'])->name('reviews');
    Route::post('/reviews/{id}/respond', [\App\Http\Controllers\Artisan\ReviewsController::class, 'respond'])->name('reviews.respond');
    Route::post('/reviews/{id}/report', [\App\Http\Controllers\Artisan\ReviewsController::class, 'report'])->name('reviews.report');

    // Booking management
    Route::get('/bookings', [\App\Http\Controllers\Artisan\BookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/{id}', [\App\Http\Controllers\Artisan\BookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}', [\App\Http\Controllers\Artisan\BookingController::class, 'update'])->name('bookings.update');

    // Messages
    Route::get('/messages', [ArtisanDashboardController::class, 'messages'])->name('messages');

    // Settings
    Route::get('/settings', [ArtisanDashboardController::class, 'settings'])->name('settings');
});

// Client routes
Route::prefix('client')->name('client.')->middleware(['auth', 'role:client'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ClientProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ClientProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update-photo', [ClientProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::post('/profile/update-personal-info', [ClientProfileController::class, 'updatePersonalInfo'])->name('profile.update-personal-info');
    Route::post('/profile/update-preferences', [ClientProfileController::class, 'updatePreferences'])->name('profile.update-preferences');

    // Points System
    Route::get('/points', [\App\Http\Controllers\Client\ClientPointsController::class, 'index'])->name('points.index');
    Route::get('/points/transactions', [\App\Http\Controllers\Client\ClientPointsController::class, 'transactions'])->name('points.transactions');

    // Store
    Route::get('/store', [\App\Http\Controllers\Client\StoreController::class, 'index'])->name('store.index');
    Route::get('/store/products', [\App\Http\Controllers\Client\StoreController::class, 'allProducts'])->name('store.all-products');
    Route::get('/store/category/{category}', [\App\Http\Controllers\Client\StoreController::class, 'category'])->name('store.category');
    Route::get('/store/product/{id}', [\App\Http\Controllers\Client\StoreController::class, 'show'])->name('store.product');
    Route::post('/store/product/{id}/purchase', [\App\Http\Controllers\Client\StoreController::class, 'purchase'])->name('store.purchase');
    Route::get('/orders', [\App\Http\Controllers\Client\StoreController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Client\StoreController::class, 'orderDetail'])->name('orders.detail');

    // Browse artisans
    Route::get('/artisans', [\App\Http\Controllers\Client\ArtisanController::class, 'index'])->name('artisans.index');
    Route::get('/artisans/{id}', [\App\Http\Controllers\Client\ArtisanController::class, 'show'])->name('artisans.show');

    // Bookings
    Route::get('/bookings', [\App\Http\Controllers\Client\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [\App\Http\Controllers\Client\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [\App\Http\Controllers\Client\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [\App\Http\Controllers\Client\BookingController::class, 'cancel'])->name('bookings.cancel');

    // Reviews
    Route::get('/reviews', [\App\Http\Controllers\Client\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/bookings/{id}/review', [\App\Http\Controllers\Client\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{id}/review', [\App\Http\Controllers\Client\ReviewController::class, 'store'])->name('reviews.store');

    // Saved Artisans
    Route::get('/saved-artisans', [\App\Http\Controllers\Client\SavedArtisanController::class, 'index'])->name('saved-artisans');
    Route::post('/artisans/{artisan}/save', [\App\Http\Controllers\Client\SavedArtisanController::class, 'saveArtisan'])->name('save-artisan');
    Route::delete('/artisans/{artisan}/unsave', [\App\Http\Controllers\Client\SavedArtisanController::class, 'unsaveArtisan'])->name('unsave-artisan');

    // Messages
    Route::get('/messages', [ClientDashboardController::class, 'messages'])->name('messages');
    Route::post('/messages/send', [\App\Http\Controllers\Client\MessageController::class, 'send'])->name('messages.send');

    // Settings
    Route::get('/settings', [ClientDashboardController::class, 'settings'])->name('settings');
});

// Messaging routes
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/start', [App\Http\Controllers\MessageController::class, 'start'])->name('messages.start');
    Route::post('/messages/{conversation}/send', [App\Http\Controllers\MessageController::class, 'sendMessage'])->name('messages.send');
});

// API endpoints
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/availability', [\App\Http\Controllers\Api\AvailabilityController::class, 'getAvailableTimeSlots'])
        ->name('api.availability');
});
