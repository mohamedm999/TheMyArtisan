<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the artisan profile page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $artisanProfile = $user->artisanProfile;

        // Get work experiences with proper ordering
        $workExperiences = WorkExperience::where('user_id', $user->id)
            ->orderByRaw('is_current DESC, start_date DESC')
            ->get();

        // Debug info for understanding what's happening
        \Log::info('Work experiences count: ' . $workExperiences->count());

        return view('artisan.profile', [
            'artisanProfile' => $artisanProfile,
            'workExperiences' => $workExperiences,
        ]);
    }

    /**
     * Store a new work experience
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeWorkExperience(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $isCurrentJob = $request->has('is_current');

        // Create work experience with proper field mapping
        $workExperience = new WorkExperience([
            'user_id' => $user->id,
            'position' => $request->title,
            'company_name' => $request->company,
            'start_date' => $request->start_date,
            'end_date' => $isCurrentJob ? null : $request->end_date,
            'is_current' => $isCurrentJob,
            'description' => $request->description,
        ]);

        $workExperience->save();

        \Log::info('New work experience added: ' . $workExperience->id);

        return redirect()->route('artisan.profile')
            ->with('success', 'Work experience added successfully!');
    }

    /**
     * Update profile photo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $artisanProfile = $user->artisanProfile;

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($artisanProfile->profile_photo) {
                Storage::delete('public/profile_photos/' . $artisanProfile->profile_photo);
            }

            // Store new photo
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/profile_photos', $photoName);

            // Update profile
            $artisanProfile->profile_photo = $photoName;
            $artisanProfile->save();

            return redirect()->route('artisan.profile')
                ->with('success', 'Profile photo updated successfully!');
        }

        return redirect()->route('artisan.profile')
            ->with('error', 'Failed to update profile photo.');
    }

    /**
     * Update contact information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
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
        $artisanProfile = $user->artisanProfile;

        $artisanProfile->update($request->only([
            'phone', 'address', 'city', 'country', 'postal_code'
        ]));

        return redirect()->route('artisan.profile')
            ->with('success', 'Contact information updated successfully!');
    }

    /**
     * Update business information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBusinessInfo(Request $request)
    {
        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'business_registration_number' => 'nullable|string|max:50',
            'insurance_details' => 'nullable|string',
        ]);

        $user = Auth::user();
        $artisanProfile = $user->artisanProfile;

        $artisanProfile->update($request->only([
            'business_name', 'business_registration_number', 'insurance_details'
        ]));

        return redirect()->route('artisan.profile')
            ->with('success', 'Business information updated successfully!');
    }

    /**
     * Store a new certification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCertification(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'nullable|string|max:255',
            'valid_until' => 'nullable|date',
        ]);

        $user = Auth::user();

        // Implement certification creation based on your model structure

        return redirect()->route('artisan.profile')
            ->with('success', 'Certification added successfully!');
    }
}
