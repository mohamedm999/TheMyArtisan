<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

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

        // Check if work_experiences table has artisan_profile_id column
        $workExperiences = [];
        $certifications = [];

        try {
            if ($artisanProfile && Schema::hasColumn('work_experiences', 'artisan_profile_id')) {
                $workExperiences = WorkExperience::where('artisan_profile_id', $artisanProfile->id)->get();
            }

            if ($artisanProfile && Schema::hasColumn('certifications', 'artisan_profile_id')) {
                $certifications = Certification::where('artisan_profile_id', $artisanProfile->id)->get();
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch work experiences or certifications: " . $e->getMessage());
            // Continue without work experiences or certifications
        }

        return view('artisan.profile', compact('artisanProfile', 'workExperiences', 'certifications'));
    }

    /**
     * Update professional information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfessionalInfo(Request $request)
    {
        $request->validate([
            'profession' => 'required|string|max:255',
            'about_me' => 'nullable|string',
            'skills' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Update professional info
        $artisanProfile->profession = $request->profession;
        $artisanProfile->about_me = $request->about_me;

        // Handle skills as JSON array
        $skills = $request->skills ? array_map('trim', explode(',', $request->skills)) : [];
        $artisanProfile->skills = $skills; // This will be stored as JSON

        $artisanProfile->experience_years = $request->experience_years;
        $artisanProfile->hourly_rate = $request->hourly_rate;
        $artisanProfile->save();

        return redirect()->route('artisan.profile')->with('success', 'Professional information updated successfully.');
    }

    /**
     * Add work experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addWorkExperience(Request $request)
    {
        try {
            $request->validate([
                'position' => 'required|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'nullable|boolean',
                'description' => 'nullable|string',
            ]);

            $user = Auth::user();

            // Find or create artisan profile
            $artisanProfile = ArtisanProfile::firstOrCreate(
                ['user_id' => $user->id],
                []
            );

            // Make sure our table exists and has the right structure
            if (!Schema::hasTable('work_experiences')) {
                Log::error('Table work_experiences does not exist');
                return redirect()->route('artisan.profile')->with('error', 'Unable to add work experience. Database issue.');
            }

            if (!Schema::hasColumn('work_experiences', 'artisan_profile_id')) {
                Log::error('Column artisan_profile_id not found in work_experiences table');
                return redirect()->route('artisan.profile')->with('error', 'Unable to add work experience. Database column missing.');
            }

            // Create work experience - map form fields to database columns
            WorkExperience::create([
                'artisan_profile_id' => $artisanProfile->id,
                'title' => $request->position, // Map position field to title column
                'company' => $request->company_name, // Map company_name field to company column
                'location' => null, // Default value since form doesn't have this field
                'start_date' => $request->start_date,
                'end_date' => $request->has('is_current') ? null : $request->end_date,
                'is_current' => $request->has('is_current'),
                'description' => $request->description,
            ]);

            return redirect()->route('artisan.profile')->with('success', 'Work experience added successfully.');
        } catch (\Exception $e) {
            Log::error('Error adding work experience: ' . $e->getMessage());
            return redirect()->route('artisan.profile')->with('error', 'Failed to add work experience: ' . $e->getMessage());
        }
    }

    /**
     * Add certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCertification(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'issuer' => 'required|string|max:255',
                'valid_until' => 'nullable|date',
            ]);

            $user = Auth::user();

            // Find or create artisan profile
            $artisanProfile = ArtisanProfile::firstOrCreate(
                ['user_id' => $user->id],
                []
            );

            // Make sure our table exists and has the right structure
            if (!Schema::hasTable('certifications')) {
                Log::error('Table certifications does not exist');
                return redirect()->route('artisan.profile')->with('error', 'Unable to add certification. Database issue.');
            }

            if (!Schema::hasColumn('certifications', 'artisan_profile_id')) {
                Log::error('Column artisan_profile_id not found in certifications table');
                return redirect()->route('artisan.profile')->with('error', 'Unable to add certification. Database column missing.');
            }

            // Create certification - map form fields to database columns
            Certification::create([
                'artisan_profile_id' => $artisanProfile->id,
                'title' => $request->name, // Map name field to title column
                'issuing_organization' => $request->issuer, // Map issuer field to issuing_organization column
                'issue_date' => now(),
                'expiry_date' => $request->valid_until,
                'credential_id' => null, // Default value
                'credential_url' => null, // Default value
                'description' => null, // Default value
            ]);

            return redirect()->route('artisan.profile')->with('success', 'Certification added successfully.');
        } catch (\Exception $e) {
            Log::error('Error adding certification: ' . $e->getMessage());
            return redirect()->route('artisan.profile')->with('error', 'Failed to add certification: ' . $e->getMessage());
        }
    }

    /**
     * Delete certification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCertification($id)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if ($artisanProfile) {
            $certification = Certification::where('id', $id)
                ->where('artisan_profile_id', $artisanProfile->id)
                ->first();

            if ($certification) {
                $certification->delete();
                return redirect()->route('artisan.profile')->with('success', 'Certification deleted successfully.');
            }
        }

        return redirect()->route('artisan.profile')->with('error', 'Certification not found.');
    }

    /**
     * Update contact information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateContactInfo(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Update contact info
        $artisanProfile->phone = $request->phone;
        $artisanProfile->address = $request->address;
        $artisanProfile->city = $request->city;
        $artisanProfile->country = $request->country;
        $artisanProfile->postal_code = $request->postal_code;
        $artisanProfile->save();

        return redirect()->route('artisan.profile')->with('success', 'Contact information updated successfully.');
    }

    /**
     * Update business information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBusinessInfo(Request $request)
    {
        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'business_registration_number' => 'nullable|string|max:50',
            'insurance_details' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Update business info
        $artisanProfile->business_name = $request->business_name;
        $artisanProfile->business_registration_number = $request->business_registration_number;
        $artisanProfile->insurance_details = $request->insurance_details;
        $artisanProfile->save();

        return redirect()->route('artisan.profile')->with('success', 'Business information updated successfully.');
    }

    /**
     * Update profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Handle file upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($artisanProfile->profile_photo) {
                Storage::disk('public')->delete($artisanProfile->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $artisanProfile->profile_photo = $path;
            $artisanProfile->save();
        }

        return redirect()->route('artisan.profile')->with('success', 'Profile photo updated successfully.');
    }
}
