<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Artisan\CertificationRequest;
use App\Http\Requests\Artisan\UpdateProfileRequest;
use App\Http\Requests\Artisan\WorkExperienceRequest;
use App\Http\Requests\Artisan\UpdatePhotoRequest;
use App\Http\Requests\Artisan\UpdateProfessionalInfoRequest;
use App\Http\Requests\Artisan\UpdateContactInfoRequest;
use App\Http\Requests\Artisan\UpdateBusinessInfoRequest;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use App\Repositories\Interfaces\CertificationRepositoryInterface;
use App\Repositories\Interfaces\WorkExperienceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('artisan.profile', compact('artisanProfile', 'certifications', 'workExperiences'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        // Handle skills as array if present in this method
        if (isset($data['skills']) && is_string($data['skills'])) {
            $skills = array_map('trim', explode(',', $data['skills']));
            $data['skills'] = array_filter($skills);
        }

        $this->artisanProfileRepository->updateOrCreate($userId, $data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function addCertification(CertificationRequest $request)
    {
        $userId = Auth::id();
        $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);

        if (!$artisanProfile) {
            $artisanProfile = $this->artisanProfileRepository->updateOrCreate($userId, []);
        }

        $this->certificationRepository->createForArtisan($artisanProfile->id, $request->validated());

        return back()->with('success', 'Certification added successfully.');
    }

    public function addWorkExperience(WorkExperienceRequest $request)
    {
        $userId = Auth::id();
        $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);

        if (!$artisanProfile) {
            $artisanProfile = $this->artisanProfileRepository->updateOrCreate($userId, []);
        }

        $data = $request->validated();
        $data['is_current'] = $data['is_current'] ?? false;

        $this->workExperienceRepository->createForArtisan($artisanProfile->id, $data);

        return back()->with('success', 'Work experience added successfully.');
    }

    public function deleteCertification($id)
    {
        $certification = $this->certificationRepository->find($id);

        if (!$certification || $certification->artisan->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $this->certificationRepository->delete($id);
        return back()->with('success', 'Certification deleted successfully.');
    }

    public function deleteWorkExperience($id)
    {
        $experience = $this->workExperienceRepository->find($id);

        if (!$experience || $experience->artisan->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $this->workExperienceRepository->delete($id);
        return back()->with('success', 'Work experience deleted successfully.');
    }

    /**
     * Store a new work experience (alias for addWorkExperience)
     */
    public function storeWorkExperience(WorkExperienceRequest $request)
    {
        $result = $this->addWorkExperience($request);

        // Store session data if needed for debugging
        $userId = Auth::id();
        $artisanProfile = $this->artisanProfileRepository->findByUserId($userId);

        if ($artisanProfile) {
            $experiences = $this->workExperienceRepository->findByArtisanId($artisanProfile->id);
            if ($experiences->isNotEmpty()) {
                session(['debug_last_experience' => $experiences->first()]);
            }
        }

        return $result;
    }

    /**
     * Store a new certification (alias for addCertification)
     */
    public function storeCertification(CertificationRequest $request)
    {
        return $this->addCertification($request);
    }

    /**
     * Update profile photo
     */
    public function updatePhoto(UpdatePhotoRequest $request)
    {
        $userId = Auth::id();
        $data = [];

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');
            $profilePhotoName = time() . '_profile.' . $profilePhoto->getClientOriginalExtension();
            $profilePhotoPath = $profilePhoto->storeAs('public/artisans', $profilePhotoName);
            $data['profile_image'] = str_replace('public/', '', $profilePhotoPath);
        }

        if ($request->hasFile('cover_photo')) {
            $coverPhoto = $request->file('cover_photo');
            $coverPhotoName = time() . '_cover.' . $coverPhoto->getClientOriginalExtension();
            $coverPhotoPath = $coverPhoto->storeAs('public/artisans', $coverPhotoName);
            $data['cover_image'] = str_replace('public/', '', $coverPhotoPath);
        }

        $this->artisanProfileRepository->updateOrCreate($userId, $data);

        return back()->with('success', 'Photos updated successfully.');
    }

    /**
     * Update professional info
     */
    public function updateProfessionalInfo(UpdateProfessionalInfoRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        // Handle skills as array
        if (isset($data['skills']) && is_string($data['skills'])) {
            $skills = array_map('trim', explode(',', $data['skills']));
            $data['skills'] = array_filter($skills);
        }

        $this->artisanProfileRepository->updateProfessionalInfo($userId, $data);

        return back()->with('success', 'Professional information updated successfully.');
    }

    /**
     * Update contact info
     */
    public function updateContactInfo(UpdateContactInfoRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        // Create the full_address field from components (if needed by your repository)
        $addressParts = [];
        if (!empty($data['address'])) $addressParts[] = $data['address'];
        if (!empty($data['city'])) $addressParts[] = $data['city'];
        if (!empty($data['postal_code'])) $addressParts[] = $data['postal_code'];
        if (!empty($data['country'])) $addressParts[] = $data['country'];

        $data['full_address'] = implode(', ', $addressParts);

        $this->artisanProfileRepository->updateContactInfo($userId, $data);

        return back()->with('success', 'Contact information updated successfully.');
    }

    /**
     * Update business info
     */
    public function updateBusinessInfo(UpdateBusinessInfoRequest $request)
    {
        $userId = Auth::id();

        $this->artisanProfileRepository->updateBusinessInfo($userId, $request->validated());

        return back()->with('success', 'Business information updated successfully.');
    }
}
