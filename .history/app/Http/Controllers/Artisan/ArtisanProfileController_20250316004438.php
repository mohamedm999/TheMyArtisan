<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $workExperiences = $artisanProfile ? WorkExperience::where('artisan_profile_id', $artisanProfile->id)->get() : [];
        $certifications = $artisanProfile ? Certification::where('artisan_profile_id', $artisanProfile->id)->get() : [];

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

        // Create work experience
        WorkExperience::create([
            'artisan_profile_id' => $artisanProfile->id,
            'title' => $request->position,
            'company' => $request->company_name,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->has('is_current'),
            'description' => $request->description,
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Work experience added successfully.');
    }

    /**
     * Add certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCertification(Request $request)
    {
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

        // Create certification - mapping form fields to model fields
        Certification::create([
            'artisan_profile_id' => $artisanProfile->id,
            'title' => $request->name,
            'issuing_organization' => $request->issuer,
            'issue_date' => now(),
            'expiry_date' => $request->valid_until,
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Certification added successfully.');
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
