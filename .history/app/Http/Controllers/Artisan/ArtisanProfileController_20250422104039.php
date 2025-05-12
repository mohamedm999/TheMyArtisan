<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Artisan\UpdateProfessionalInfoRequest;
use App\Http\Requests\Artisan\AddWorkExperienceRequest;
use App\Http\Requests\Artisan\AddCertificationRequest;
use App\Http\Requests\Artisan\UpdateContactInfoRequest;
use App\Http\Requests\Artisan\UpdateBusinessInfoRequest;
use App\Http\Requests\Artisan\UpdateProfilePhotoRequest;
use App\Http\Requests\Artisan\UpdateCategoriesRequest;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;

class ArtisanProfileController extends Controller
{
    /**
     * The artisan profile repository implementation.
     *
     * @var ArtisanProfileRepositoryInterface
     */
    protected $artisanProfileRepository;

    /**
     * Create a new controller instance.
     *
     * @param ArtisanProfileRepositoryInterface $artisanProfileRepository
     * @return void
     */
    public function __construct(ArtisanProfileRepositoryInterface $artisanProfileRepository)
    {
        $this->artisanProfileRepository = $artisanProfileRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $artisanProfile = $this->artisanProfileRepository->getByUserId($user->id);

        $workExperiences = [];
        $certifications = [];
        $categories = Category::all();
        $selectedCategories = [];
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $cities = collect(); // Initialize as empty collection

        if ($artisanProfile) {
            $workExperiences = $this->artisanProfileRepository->getWorkExperiences($artisanProfile->id);
            $certifications = $this->artisanProfileRepository->getCertifications($artisanProfile->id);
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
        $this->artisanProfileRepository->updateProfessionalInfo($user->id, $request->validated());

        return redirect()->route('artisan.profile')->with('success', 'Professional information updated successfully.');
    }

    public function addWorkExperience(AddWorkExperienceRequest $request)
    {
        $user = Auth::user();
        $artisanProfile = $this->artisanProfileRepository->getByUserId($user->id);
        
        if (!$artisanProfile) {
            $artisanProfile = $this->artisanProfileRepository->findOrCreateByUserId($user->id);
        }

        $this->artisanProfileRepository->addWorkExperience(
            $artisanProfile->id, 
            $request->validated()
        );

        return redirect()->route('artisan.profile')
            ->with('success', 'Work experience added successfully.')
            ->with('refreshFormData', true);
    }

    public function addCertification(AddCertificationRequest $request)
    {
        $user = Auth::user();
        $artisanProfile = $this->artisanProfileRepository->getByUserId($user->id);
        
        if (!$artisanProfile) {
            $artisanProfile = $this->artisanProfileRepository->findOrCreateByUserId($user->id);
        }

        $this->artisanProfileRepository->addCertification(
            $artisanProfile->id, 
            $request->validated()
        );

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
        $artisanProfile = $this->artisanProfileRepository->getByUserId($user->id);

        if ($artisanProfile) {
            $deleted = $this->artisanProfileRepository->deleteCertification($id, $artisanProfile->id);
            
            if ($deleted) {
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
        $this->artisanProfileRepository->updateContactInfo($user->id, $request->validated());

        return redirect()->route('artisan.profile')->with('success', 'Contact information updated successfully.');
    }

    public function updateBusinessInfo(UpdateBusinessInfoRequest $request)
    {
        $user = Auth::user();
        $this->artisanProfileRepository->updateBusinessInfo($user->id, $request->validated());

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

            // Handle file upload
            if ($request->hasFile('profile_photo')) {
                $path = $this->artisanProfileRepository->updateProfilePhoto($user->id, $request->file('profile_photo'));
                
                if ($path) {
                    return redirect()->route('artisan.profile')->with('success', 'Profile photo updated successfully.');
                }
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
        $artisanProfile = $this->artisanProfileRepository->getByUserId($user->id);
        
        if (!$artisanProfile) {
            $artisanProfile = $this->artisanProfileRepository->findOrCreateByUserId($user->id);
        }

        $this->artisanProfileRepository->updateCategories($artisanProfile->id, $request->categories);

        return redirect()->route('artisan.profile')->with('success', 'Specialty categories updated successfully.');
    }
}
