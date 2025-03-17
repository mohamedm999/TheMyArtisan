<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use App\Repositories\Interfaces\WorkExperienceRepositoryInterface;
use App\Repositories\Interfaces\CertificationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtisanProfileController extends Controller
{
    protected $artisanProfileRepository;
    protected $workExperienceRepository;
    protected $certificationRepository;

    public function __construct(
        ArtisanProfileRepositoryInterface $artisanProfileRepository,
        WorkExperienceRepositoryInterface $workExperienceRepository,
        CertificationRepositoryInterface $certificationRepository
    ) {
        $this->artisanProfileRepository = $artisanProfileRepository;
        $this->workExperienceRepository = $workExperienceRepository;
        $this->certificationRepository = $certificationRepository;
    }

    public function index()
    {
        $userId = Auth::id();
        $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);
        $workExperiences = $artisanProfile ? $this->workExperienceRepository->findByArtisanId($artisanProfile->id) : [];
        $certifications = $artisanProfile ? $this->certificationRepository->findByArtisanId($artisanProfile->id) : [];

        return view('artisan.profile', compact('artisanProfile', 'workExperiences', 'certifications'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_image = $path;
            $user->save();

            return redirect()->route('artisan.profile')->with('success', 'Profile photo updated successfully.');
        }

        return redirect()->route('artisan.profile')->with('error', 'Failed to update profile photo.');
    }

    public function updateContactInfo(Request $request)
    {
        $data = $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $userId = Auth::id();

        // Create the full_address field from components
        $addressParts = [];
        if (!empty($data['address'])) $addressParts[] = $data['address'];
        if (!empty($data['city'])) $addressParts[] = $data['city'];
        if (!empty($data['postal_code'])) $addressParts[] = $data['postal_code'];
        if (!empty($data['country'])) $addressParts[] = $data['country'];

        $data['full_address'] = implode(', ', $addressParts);

        $this->artisanProfileRepository->updateContactInfo($userId, $data);

        return redirect()->route('artisan.profile')->with('success', 'Contact information updated successfully.');
    }

    // Add other methods for business info, professional info, etc.
    // ...

    public function addWorkExperience(Request $request)
    {
        $data = $request->validate([
            'position' => 'required|string|max:100',
            'company_name' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $userId = Auth::id();
        $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);

        if (!$artisanProfile) {
            // Create a basic profile first
            $artisanProfile = $this->artisanProfileRepository->updateOrCreate($userId, []);
        }

        $this->workExperienceRepository->createForArtisan($artisanProfile->id, $data);

        return redirect()->route('artisan.profile')->with('success', 'Work experience added successfully.');
    }

    public function addCertification(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'issuer' => 'required|string|max:100',
            'valid_until' => 'required|date',
        ]);

        $userId = Auth::id();
        $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);

        if (!$artisanProfile) {
            // Create a basic profile first
            $artisanProfile = $this->artisanProfileRepository->updateOrCreate($userId, []);
        }

        $this->certificationRepository->createForArtisan($artisanProfile->id, $data);

        return redirect()->route('artisan.profile')->with('success', 'Certification added successfully.');
    }

    public function deleteCertification($id)
    {
        $this->certificationRepository->delete($id);
        return redirect()->route('artisan.profile')->with('success', 'Certification deleted successfully.');
    }
}
