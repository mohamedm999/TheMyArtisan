<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Client\ArtisanController;

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

    public function profile()
    {
        // Redirect to the dedicated profile controller
        return app(ClientProfileController::class)->index();
    }

    public function findArtisans()
    {
        // Redirect to the ArtisanController which properly handles fetching artisans
        return app(ArtisanController::class)->index(request());
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
