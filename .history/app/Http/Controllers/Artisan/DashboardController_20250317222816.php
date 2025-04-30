<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:artisan');
    }

    public function index()
    {
        // Get current authenticated user
        $user = auth()->user();

        // Make sure we have an artisanProfile
        $artisanProfile = $user->artisanProfile;

        // If artisanProfile doesn't exist, create a default one or initialize as null
        if (!$artisanProfile) {
            // Option 1: Create a default profile
            // $artisanProfile = new \App\Models\ArtisanProfile();
            // $artisanProfile->user_id = $user->id;
            // $artisanProfile->is_available = false;
            // $artisanProfile->save();

            // Option 2: Initialize as null but handle in view
            $artisanProfile = null;
        }

        // Other data for the dashboard
        // ...

        return view('artisan.dashboard', compact('artisanProfile'));
    }

    public function profile()
    {
        return view('artisan.profile');
    }

    public function services()
    {
        return view('artisan.services');
    }

    public function bookings()
    {
        return view('artisan.bookings');
    }

    /**
     * Show the artisan's schedule.
     *
     * @return \Illuminate\View\View
     */
    public function schedule(Request $request)
    {
        // Redirect to the dedicated schedule controller
        return app(ScheduleController::class)->index($request);
    }

    /**
     * Show the artisan's reviews.
     *
     * @return \Illuminate\View\View
     */
    public function reviews(Request $request)
    {
        // Redirect to the dedicated reviews controller
        return app(ReviewsController::class)->index($request);
    }

    public function messages()
    {
        return view('artisan.messages');
    }

    public function settings()
    {
        return view('artisan.settings');
    }
}
