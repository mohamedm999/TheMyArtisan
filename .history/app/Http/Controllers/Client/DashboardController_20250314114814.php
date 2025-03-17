<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:client');
    }

    public function index()
    {
        return view('client.dashboard');
    }

    /**
     * Show the client's profile page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        // Redirect to the dedicated profile controller
        return app(ClientProfileController::class)->index();
    }

    public function findArtisans()
    {
        return view('client.find-artisans');
    }

    public function bookings()
    {
        return view('client.bookings');
    }

    public function savedArtisans()
    {
        return view('client.saved-artisans');
    }

    public function messages()
    {
        return view('client.messages');
    }

    public function settings()
    {
        return view('client.settings');
    }
}
