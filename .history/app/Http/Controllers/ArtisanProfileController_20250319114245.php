<?php

namespace App\Http\Controllers;

use App\Models\ArtisanProfile;
use App\Models\WorkExperience;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtisanProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();
        
        // Fix: Change artisan_profiles_id to artisan_profile_id
        $workExperiences = $artisanProfile ? WorkExperience::where('artisan_profile_id', $artisanProfile->id)->get() : collect([]);
        $certifications = $artisanProfile ? Certification::where('artisan_profile_id', $artisanProfile->id)->get() : collect([]);

        return view('artisan.profile', compact('artisanProfile', 'workExperiences', 'certifications'));
    }

    // ...existing code...
}