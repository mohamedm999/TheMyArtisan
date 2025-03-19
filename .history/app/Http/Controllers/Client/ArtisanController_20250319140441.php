<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;

class ArtisanController extends Controller
{
    /**
     * Display a listing of the artisans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artisans = ArtisanProfile::with([
            'user', 
            'services', 
            'certifications',
            'workExperiences',
            'reviews'
        ])->get();
        
        return view('client.artisans.index', compact('artisans'));
    }

    /**
     * Display the specified artisan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artisan = ArtisanProfile::with([
            'user', 
            'services.category', 
            'certifications', 
            'workExperiences',
            'availabilities',
            'reviews'
        ])->findOrFail($id);
        
        return view('client.artisans.show', compact('artisan'));
    }
}
