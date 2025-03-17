<?php

namespace App\Http\Controllers\Artisan;

use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArtisanProfileController extends Controller
{
    public function index()
    {
        $artisanProfile = ArtisanProfile::where('user_id', Auth::id())->first();

        // Keep the ordering to show newest experiences first
        $workExperiences = WorkExperience::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $certifications = Certification::where('user_id', Auth::id())->get();

        return view('artisan.profile', compact('artisanProfile', 'certifications', 'workExperiences'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profession' => 'required|string|max:255',
            'about_me' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            // Add validation for other fields as needed
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle skills as array
        $skills = $request->has('skills') ? explode(',', $request->skills) : [];

        ArtisanProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            array_merge(
                $request->except('skills', '_token'),
                ['skills' => $skills]
            )
        );

        return back()->with('success', 'Profile updated successfully.');
    }

    public function addCertification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'valid_until' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Certification::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'issuer' => $request->issuer,
            'valid_until' => $request->valid_until,
        ]);

        return back()->with('success', 'Certification added successfully.');
    }

    public function addWorkExperience(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        WorkExperience::create([
            'user_id' => Auth::id(),
            'position' => $request->position,
            'company_name' => $request->company_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => $request->is_current ?? false,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Work experience added successfully.');
    }

    public function deleteCertification($id)
    {
        $certification = Certification::findOrFail($id);

        if ($certification->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $certification->delete();
        return back()->with('success', 'Certification deleted successfully.');
    }

    public function deleteWorkExperience($id)
    {
        $experience = WorkExperience::findOrFail($id);

        if ($experience->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $experience->delete();
        return back()->with('success', 'Work experience deleted successfully.');
    }

    /**
     * Store a new work experience (alias for addWorkExperience)
     */
    public function storeWorkExperience(Request $request)
    {
        // Keep storing the experience in session as it seems important for functionality
        $result = $this->addWorkExperience($request);

        // Store the newly created work experience in the session
        $lastExperience = WorkExperience::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastExperience) {
            session(['debug_last_experience' => $lastExperience]);
        }

        return $result;
    }

    /**
     * Store a new certification (alias for addCertification)
     */
    public function storeCertification(Request $request)
    {
        return $this->addCertification($request);
    }

    /**
     * Update profile photo
     */
    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [];

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            $profilePhotoName = time() . '_profile.' . $profilePhoto->getClientOriginalExtension();
            
            // Store directly in public/storage/artisans folder
            $profilePhotoPath = $profilePhoto->storePublicly('artisans', 'public');
            
            // Update user profile image directly
            $user = Auth::user();
            $user->profile_image = $profilePhotoPath;
            $user->save();
            
            // Also store in artisan profile for consistency
            $data['profile_image'] = $profilePhotoPath;
        }

        if ($request->hasFile('cover_photo')) {
            $coverPhoto = $request->file('cover_photo');
            $coverPhotoName = time() . '_cover.' . $coverPhoto->getClientOriginalExtension();
            
            // Store directly in public/storage/artisans folder
            $coverPhotoPath = $coverPhoto->storePublicly('artisans', 'public');
            $data['cover_image'] = $coverPhotoPath;
        }

        // Only update the ArtisanProfile if we have data to update
        if (!empty($data)) {
            ArtisanProfile::updateOrCreate(
                ['user_id' => Auth::id()],
                $data
            );
        }

        return back()->with('success', 'Photos updated successfully.');
    }

    /**
     * Update professional info
     */
    public function updateProfessionalInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profession' => 'required|string|max:255',
            'about_me' => 'nullable|string',
            'skills' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle skills as array
        $skills = $request->has('skills') ? explode(',', $request->skills) : [];

        ArtisanProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'profession' => $request->profession,
                'about_me' => $request->about_me,
                'skills' => $skills,
                'experience_years' => $request->experience_years,
                'hourly_rate' => $request->hourly_rate,
            ]
        );

        return back()->with('success', 'Professional information updated successfully.');
    }

    /**
     * Update contact info
     */
    public function updateContactInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        ArtisanProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only(['phone', 'address', 'city', 'country', 'postal_code'])
        );

        return back()->with('success', 'Contact information updated successfully.');
    }

    /**
     * Update business info
     */
    public function updateBusinessInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'nullable|string|max:255',
            'business_registration_number' => 'nullable|string|max:255',
            'insurance_details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        ArtisanProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only(['business_name', 'business_registration_number', 'insurance_details'])
        );

        return back()->with('success', 'Business information updated successfully.');
    }
}
