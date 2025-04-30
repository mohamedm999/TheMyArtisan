<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtisanProfile;

class ArtisanController extends Controller
{
    // ...existing code...

    public function index()
    {
        // Load artisan profiles with all required relationships
        $artisans = ArtisanProfile::with([
            'user',
            'services',
            'reviews',
            'workExperiences',
            'certifications'
        ])->get();

        return view('client.artisans.index', compact('artisans'));
    }

    public function show($id)
    {
        $artisan = ArtisanProfile::with([
            'user',
            'services',
            'reviews',
            'workExperiences',
            'certifications'
        ])->findOrFail($id);

        return view('client.artisans.show', compact('artisan'));
    }

    // ...existing code...
}
