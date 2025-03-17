<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkExperience;
use App\Models\Certification;
use App\Models\ArtisanProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtisanProfileController extends Controller
{
    /**
     * Display the artisan profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $artisanProfile = $user->artisanProfile ?? ArtisanProfile::create(['user_id' => $user->id]);
        $workExperiences = WorkExperience::where('user_id', $user->id)->orderBy('start_date', 'desc')->get();
        $certifications = Certification::where('user_id', $user->id)->get();

        return view('artisan.profile', compact('user', 'artisanProfile', 'workExperiences', 'certifications'));
    }

    /**
     * Update the artisan's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $artisanProfile = $user->artisanProfile ?? ArtisanProfile::create(['user_id' => $user->id]);

        // Handle photo upload logic here
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($artisanProfile->profile_photo && Storage::exists('public/profile_photos/' . $artisanProfile->profile_photo)) {
                Storage::delete('public/profile_photos/' . $artisanProfile->profile_photo);
            }

            $filename = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/profile_photos', $filename);

            $artisanProfile->profile_photo = $filename;
            $artisanProfile->save();
        }

        return redirect()->route('artisan.profile')->with('success', 'Profile photo updated successfully');
    }

    /**
     * Update the artisan's professional information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfessionalInfo(Request $request)
    {
        $request->validate([
            'profession' => 'required|string|max:255',
            'about_me' => 'required|string',
            'skills' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();
        $artisanProfile = $user->artisanProfile ?? ArtisanProfile::create(['user_id' => $user->id]);

        $artisanProfile->update([
            'profession' => $request->profession,
            'about_me' => $request->about_me,
            'skills' => $request->skills ? explode(',', $request->skills) : null,
            'experience_years' => $request->experience_years,
            'hourly_rate' => $request->hourly_rate,
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Professional information updated successfully');
    }

    /**
     * Update the artisan's contact information.
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
        $artisanProfile = $user->artisanProfile ?? ArtisanProfile::create(['user_id' => $user->id]);

        $artisanProfile->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Contact information updated successfully');
    }

    /**
     * Update the artisan's business information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBusinessInfo(Request $request)
    {
        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'business_registration_number' => 'nullable|string|max:100',
            'insurance_details' => 'nullable|string',
        ]);

        $user = Auth::user();
        $artisanProfile = $user->artisanProfile ?? ArtisanProfile::create(['user_id' => $user->id]);

        $artisanProfile->update([
            'business_name' => $request->business_name,
            'business_registration_number' => $request->business_registration_number,
            'insurance_details' => $request->insurance_details,
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Business information updated successfully');
    }

    /**
     * Store a new work experience.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWorkExperience(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'required|string',
        ]);

        WorkExperience::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'company' => $request->company,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'is_current' => $request->has('is_current'),
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Work experience added successfully');
    }

    /**
     * Store a new certification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCertification(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'valid_until' => 'required|date',
        ]);

        Certification::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'issuer' => $request->issuer,
            'valid_until' => $request->valid_until,
        ]);

        return redirect()->route('artisan.profile')->with('success', 'Certification added successfully');
    }
}
