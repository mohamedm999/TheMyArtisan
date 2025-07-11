<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Requests\Artisan\UpdateProfessionalInfoRequest;
use App\Http\Requests\Artisan\AddWorkExperienceRequest;
use App\Http\Requests\Artisan\AddCertificationRequest;
use App\Http\Requests\Artisan\UpdateContactInfoRequest;
use App\Http\Requests\Artisan\UpdateBusinessInfoRequest;
use App\Http\Requests\Artisan\UpdateProfilePhotoRequest;
use App\Http\Requests\Artisan\UpdateCategoriesRequest;

class ArtisanProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        $workExperiences = [];
        $certifications = [];
        $categories = Category::all();
        $selectedCategories = [];
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $cities = collect(); // Initialize as empty collection

        if ($artisanProfile) {
            $workExperiences = WorkExperience::where('artisan_profile_id', $artisanProfile->id)->get();
            $certifications = Certification::where('artisan_profile_id', $artisanProfile->id)->get();
            $selectedCategories = $artisanProfile->categories->pluck('id')->toArray();

            // Load cities for the selected country
            if ($artisanProfile->country_id) {
                $cities = City::where('country_id', $artisanProfile->country_id)
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get();
            }
        }

        return view('artisan.profile', compact(
            'artisanProfile',
            'workExperiences',
            'certifications',
            'categories',
            'selectedCategories',
            'countries',
            'cities'
        ));
    }

    public function updateProfessionalInfo(UpdateProfessionalInfoRequest $request)
    {
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

    public function addWorkExperience(AddWorkExperienceRequest $request)
    {
        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Check if current position
        $isCurrentChecked = filter_var($request->input('is_current', false), FILTER_VALIDATE_BOOLEAN);

        // Create work experience
        $workExp = new WorkExperience();
        $workExp->artisan_profile_id = $artisanProfile->id;
        $workExp->position = $request->title;
        $workExp->company_name = $request->company ?? '';
        $workExp->start_date = $request->start_date;
        $workExp->end_date = $isCurrentChecked ? null : $request->end_date;
        $workExp->is_current = $isCurrentChecked ? 1 : 0;
        $workExp->description = $request->description ?? '';
        $workExp->save();

        return redirect()->route('artisan.profile')
            ->with('success', 'Work experience added successfully.')
            ->with('refreshFormData', true);
    }

    public function addCertification(AddCertificationRequest $request)
    {
        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Create certification
        $certification = new Certification();
        $certification->artisan_profile_id = $artisanProfile->id;
        $certification->name = $request->title;
        $certification->issuer = $request->issuing_organization;
        $certification->valid_until = $request->expiry_date;
        $certification->save();

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
     * Get cities for a specific country.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCities(Request $request)
    {
        $countryId = $request->input('country_id');
        $cities = City::where('country_id', $countryId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json($cities);
    }

    public function updateContactInfo(UpdateContactInfoRequest $request)
    {
        $user = Auth::user();

        // Find or create artisan profile
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        // Update contact info
        $artisanProfile->phone = $request->phone;
        $artisanProfile->address = $request->address;
        $artisanProfile->city_id = $request->city_id;
        $artisanProfile->country_id = $request->country_id;
        $artisanProfile->state = $request->state;
        $artisanProfile->postal_code = $request->postal_code;

        // Update legacy fields for backward compatibility
        if ($request->city_id) {
            $city = City::find($request->city_id);
            if ($city) {
                $artisanProfile->city = $city->name;
            }
        }

        if ($request->country_id) {
            $country = Country::find($request->country_id);
            if ($country) {
                $artisanProfile->country = $country->name;
            }
        }

        $artisanProfile->save();

        return redirect()->route('artisan.profile')->with('success', 'Contact information updated successfully.');
    }

    public function updateBusinessInfo(UpdateBusinessInfoRequest $request)
    {
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
     * @param  \App\Http\Requests\Artisan\UpdateProfilePhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfilePhoto(UpdateProfilePhotoRequest $request)
    {
        try {
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

                // Log success for debugging
                Log::info('Profile photo updated successfully', [
                    'user_id' => $user->id,
                    'path' => $path
                ]);

                return redirect()->route('artisan.profile')->with('success', 'Profile photo updated successfully.');
            }

            return redirect()->route('artisan.profile')->with('error', 'No file was uploaded.');
        } catch (\Exception $e) {
            Log::error('Error updating profile photo: ' . $e->getMessage());
            return redirect()->route('artisan.profile')->with('error', 'Failed to update profile photo: ' . $e->getMessage());
        }
    }

    /**
     * Update the artisan's selected categories.
     *
     * @param  \App\Http\Requests\Artisan\UpdateCategoriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCategories(UpdateCategoriesRequest $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        $artisanProfile->categories()->sync($request->categories);

        return redirect()->route('artisan.profile')->with('success', 'Specialty categories updated successfully.');
    }
}
