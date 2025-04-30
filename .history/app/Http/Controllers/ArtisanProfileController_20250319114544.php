<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class ArtisanProfileController extends Controller
{
    /**
     * Show the artisan profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();
        
        $workExperiences = [];
        $certifications = [];
        
        if ($artisanProfile) {
            // Updated to use the correct column name
            $workExperiences = WorkExperience::where('artisan_profile_id', $artisanProfile->id)->get();
            
            // Also check if certifications need to be updated
            $certifications = Certification::where('artisan_profile_id', $artisanProfile->id)->get();
        }

        return view('artisan.profile', compact('artisanProfile', 'workExperiences', 'certifications'));
    }

    // ...existing code...
}
