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
        return view('artisan.dashboard');
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
