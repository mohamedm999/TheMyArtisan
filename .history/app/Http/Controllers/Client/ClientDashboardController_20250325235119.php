<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    /**
     * Display the client's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('client.dashboard');
    }

    /**
     * Display the client's profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('client.profile');
    }

    /**
     * Display the client's bookings.
     *
     * @return \Illuminate\View\View
     */
    public function bookings()
    {
        return view('client.bookings');
    }

    /**
     * Display the client's saved artisans.
     *
     * @return \Illuminate\View\View
     */
    public function savedArtisans()
    {
        // Delegate to the SavedArtisanController
        $savedArtisanController = new \App\Http\Controllers\Client\SavedArtisanController();
        return $savedArtisanController->index();
    }

    /**
     * Display the client's messages.
     *
     * @return \Illuminate\View\View
     */
    public function messages()
    {
        return view('client.messages');
    }

    /**
     * Display the client's settings.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        return view('client.settings');
    }
}
