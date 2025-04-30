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
     * Display the specified artisan with ALL relationships.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Load all relationships to display comprehensive profile
        $artisan = ArtisanProfile::with([
            'user',                    // Basic user info
            'services.category',       // Services with their categories
            'certifications',          // Professional certifications
            'workExperiences',         // Work history
            'availabilities',          // Available time slots
            'reviews.clientProfile',   // Reviews with client information
            'reviews.service',         // Service associated with each review
            'bookings.service',        // Bookings with associated services
            'bookings.clientProfile',  // Clients who made bookings
        ])->findOrFail($id);

        // Make property accessible in view for consistency with template
        $artisan->name = $artisan->user->firstname . ' ' . $artisan->user->lastname;
        $artisan->average_rating = $artisan->getAverageRatingAttribute();
        $artisan->reviews_count = $artisan->reviews->count();
        $artisan->location = $artisan->city ?? 'Morocco';
        $artisan->speciality = implode(', ', (array)$artisan->skills ?? []);

        // Add portfolioItems for template compatibility (if you have a real implementation)
        $artisan->portfolioItems = collect(); // Empty collection as placeholder

        return view('client.artisans.show', compact('artisan'));
    }
}
