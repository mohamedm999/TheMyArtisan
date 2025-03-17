<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use App\Repositories\Interfaces\WorkExperienceRepositoryInterface;
use App\Repositories\Interfaces\CertificationRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtisanProfileController extends Controller
{
    protected $artisanProfileRepository;
    protected $workExperienceRepository;
    protected $certificationRepository;
    protected $userRepository;

    public function __construct(
        ArtisanProfileRepositoryInterface $artisanProfileRepository,
        WorkExperienceRepositoryInterface $workExperienceRepository,
        CertificationRepositoryInterface $certificationRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->artisanProfileRepository = $artisanProfileRepository;
        $this->workExperienceRepository = $workExperienceRepository;
        $this->certificationRepository = $certificationRepository;
        $this->userRepository = $userRepository;
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|max:2048',
        ]);

        $userId = Auth::id();
        $user = $this->userRepository->find($userId);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $this->userRepository->update($userId, ['profile_image' => $path]);

            return redirect()->route('artisan.profile')->with('success', 'Profile photo updated successfully.');
        }

        return redirect()->route('artisan.profile')->with('error', 'Failed to update profile photo.');
    }

    // ...remaining methods...
}
