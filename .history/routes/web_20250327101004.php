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
use Illuminate\Http\Request; // Add this import for the Request class

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
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // User routes
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);

    // Other admin routes
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

    // Booking routes
    Route::get('/bookings', [\App\Http\Controllers\Artisan\BookingController::class, 'index'])->name('artisan.bookings');
    Route::get('/bookings/{id}', [\App\Http\Controllers\Artisan\BookingController::class, 'show'])->name('artisan.bookings.show');
    Route::put('/bookings/{booking}', [\App\Http\Controllers\Artisan\BookingController::class, 'update'])->name('artisan.bookings.update');
});

// Artisan review routes
Route::middleware(['auth', 'verified', 'role:artisan'])->prefix('artisan')->name('artisan.')->group(function () {
    Route::get('/reviews', [App\Http\Controllers\Artisan\ReviewsController::class, 'index'])->name('reviews');
    Route::post('/reviews/respond/{id}', [App\Http\Controllers\Artisan\ReviewsController::class, 'respond'])->name('reviews.respond');
    Route::post('/reviews/report/{id}', [App\Http\Controllers\Artisan\ReviewsController::class, 'report'])->name('reviews.report');
});

// Artisan Profile Routes - consolidated for clarity and to avoid duplicate routes
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
    // Fix: Remove duplicate /artisan prefix and use full namespace
    Route::post('/profile/categories', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'updateCategories'])->name('profile.categories');

    // Add route to get cities by country
    Route::get('/get-cities', [App\Http\Controllers\Artisan\ArtisanProfileController::class, 'getCities']);
});

// Client routes
Route::prefix('client')->name('client.')->middleware(['auth', 'role:client'])->group(function () {
    Route::get('dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ClientDashboardController::class, 'profile'])->name('profile');
    Route::get('/bookings', [ClientDashboardController::class, 'bookings'])->name('bookings');
    Route::get('/saved-artisans', [ClientDashboardController::class, 'savedArtisans'])->name('saved-artisans');
    Route::get('/messages', [ClientDashboardController::class, 'messages'])->name('messages');
    Route::get('/settings', [ClientDashboardController::class, 'settings'])->name('settings');

    // Client profile routes
    Route::get('/profile', [ClientProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ClientProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update-photo', [ClientProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::post('/profile/update-personal-info', [ClientProfileController::class, 'updatePersonalInfo'])->name('profile.update-personal-info');
    Route::post('/profile/update-preferences', [ClientProfileController::class, 'updatePreferences'])->name('profile.update-preferences');

    // Fix: Use fully qualified namespace for the Client ArtisanController
    Route::get('/artisans', [App\Http\Controllers\Client\ArtisanController::class, 'index'])->name('artisans.index');
    Route::get('/artisans/{id}', [App\Http\Controllers\Client\ArtisanController::class, 'show'])->name('artisans.show');
});

// Debug route for testing reviews
Route::get('/debug-review-routes/{id}', function ($id) {
    $routeUrl = route('client.reviews.create', $id);
    return [
        'booking_id' => $id,
        'generated_url' => $routeUrl,
        'route_exists' => Route::has('client.reviews.create')
    ];
});

// Client reviews routes - updated with more specific controller references and debugging
Route::middleware(['auth', 'verified', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/reviews', [App\Http\Controllers\Client\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/bookings/{id}/review', [App\Http\Controllers\Client\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{id}/review', [App\Http\Controllers\Client\ReviewController::class, 'store'])->name('reviews.store');
});

// API endpoints for the booking system
Route::middleware(['auth', 'role:client'])->prefix('api')->group(function () {
    Route::get('/availability', [App\Http\Controllers\Api\AvailabilityController::class, 'getAvailableTimeSlots'])
        ->name('api.availability');
});

// Client bookings routes
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::post('/bookings', [App\Http\Controllers\Client\BookingController::class, 'store'])
        ->name('client.bookings.store');
    Route::get('/bookings', [App\Http\Controllers\Client\BookingController::class, 'index'])
        ->name('client.bookings.index');
    Route::get('/bookings/{id}', [App\Http\Controllers\Client\BookingController::class, 'show'])
        ->name('client.bookings.show');
    Route::post('/bookings/{id}/cancel', [App\Http\Controllers\Client\BookingController::class, 'cancel'])
        ->name('client.bookings.cancel');
    Route::post('/messages/send', [App\Http\Controllers\Client\MessageController::class, 'send'])
        ->name('client.messages.send');
}); // Add this closing parenthesis

// Client saved artisans routes - clean up duplicated routes
Route::middleware(['auth', 'role:client'])->group(function () {
    // Saved Artisan routes - consolidated
    Route::get('/saved-artisans', [App\Http\Controllers\Client\SavedArtisanController::class, 'index'])->name('client.saved-artisans');
    Route::post('/artisans/{artisan}/save', [App\Http\Controllers\Client\SavedArtisanController::class, 'saveArtisan'])->name('client.save-artisan');
    Route::delete('/artisans/{artisan}/unsave', [App\Http\Controllers\Client\SavedArtisanController::class, 'unsaveArtisan'])->name('client.unsave-artisan');
});

// Debug route to check user roles - remove this in production
Route::get('/debug/user-roles', function () {
    if (!auth()->check()) {
        return 'Not logged in';
    }

    $user = auth()->user();
    $roles = $user->roles()->pluck('name')->toArray();

    return [
        'user_id' => $user->id,
        'name' => $user->firstname . ' ' . $user->lastname,
        'roles' => $roles,
        'has_admin_role' => $user->hasRole('admin'),
        'is_admin' => isset($user->is_admin) ? (bool)$user->is_admin : false,
    ];
})->middleware('auth');
