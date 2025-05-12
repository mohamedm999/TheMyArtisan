<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    // ...existing code...

    public function index()
    {
        // Instead of trying to access $user->profile, directly query for artisan profiles
        $artisans = \App\Models\ArtisanProfile::with(['user', 'services', 'reviews'])->get();

        return view('client.artisans.index', compact('artisans'));
    }

    // ...existing code...
}
