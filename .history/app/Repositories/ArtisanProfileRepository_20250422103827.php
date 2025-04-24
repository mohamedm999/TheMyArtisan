<?php

namespace App\Repositories;

use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use App\Models\City;
use App\Models\Country;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ArtisanProfileRepository implements ArtisanProfileRepositoryInterface
{
    /**
     * Get artisan profile by user ID
     *
     * @param int $userId
     * @return ArtisanProfile|null
     */
    public function getByUserId(int $userId)
    {
        return ArtisanProfile::where('user_id', $userId)->first();
    }

    /**
     * Find or create an artisan profile for a user
     *
     * @param int $userId
     * @return ArtisanProfile
     */
    public function findOrCreateByUserId(int $userId): ArtisanProfile
    {
        return ArtisanProfile::firstOrCreate(
            ['user_id' => $userId],
            []
        );
    }

    /**
     * Update professional information
     *
     * @param int $userId
     * @param array $data
     * @return ArtisanProfile
     */
    public function updateProfessionalInfo(int $userId, array $data): ArtisanProfile
    {
        $artisanProfile = $this->findOrCreateByUserId($userId);
        
        $artisanProfile->profession = $data['profession'];
        $artisanProfile->about_me = $data['about_me'];
        
        // Handle skills as JSON array
        $skills = isset($data['skills']) ? array_map('trim', explode(',', $data['skills'])) : [];
        $artisanProfile->skills = $skills;
        
        $artisanProfile->experience_years = $data['experience_years'];
        $artisanProfile->hourly_rate = $data['hourly_rate'];
        $artisanProfile->save();
        
        return $artisanProfile;
    }

    /**
     * Add work experience
     *
     * @param int $artisanProfileId
     * @param array $data
     * @return WorkExperience
     */
    public function addWorkExperience(int $artisanProfileId, array $data): WorkExperience
    {
        $isCurrentChecked = filter_var($data['is_current'] ?? false, FILTER_VALIDATE_BOOLEAN);
        
        $workExp = new WorkExperience();
        $workExp->artisan_profile_id = $artisanProfileId;
        $workExp->position = $data['title'];
        $workExp->company_name = $data['company'] ?? '';
        $workExp->start_date = $data['start_date'];
        $workExp->end_date = $isCurrentChecked ? null : $data['end_date'];
        $workExp->is_current = $isCurrentChecked ? 1 : 0;
        $workExp->description = $data['description'] ?? '';
        $workExp->save();
        
        return $workExp;
    }

    /**
     * Add certification
     *
     * @param int $artisanProfileId
     * @param array $data
     * @return Certification
     */
    public function addCertification(int $artisanProfileId, array $data): Certification
    {
        $certification = new Certification();
        $certification->artisan_profile_id = $artisanProfileId;
        $certification->name = $data['title'];
        $certification->issuer = $data['issuing_organization'];
        $certification->valid_until = $data['expiry_date'];
        $certification->save();
        
        return $certification;
    }

    /**
     * Delete certification
     *
     * @param int $certificationId
     * @param int $artisanProfileId
     * @return bool
     */
    public function deleteCertification(int $certificationId, int $artisanProfileId): bool
    {
        $certification = Certification::where('id', $certificationId)
            ->where('artisan_profile_id', $artisanProfileId)
            ->first();
            
        if ($certification) {
            return $certification->delete();
        }
        
        return false;
    }

    /**
     * Update contact information
     *
     * @param int $userId
     * @param array $data
     * @return ArtisanProfile
     */
    public function updateContactInfo(int $userId, array $data): ArtisanProfile
    {
        $artisanProfile = $this->findOrCreateByUserId($userId);
        
        $artisanProfile->phone = $data['phone'];
        $artisanProfile->address = $data['address'];
        $artisanProfile->city_id = $data['city_id'];
        $artisanProfile->country_id = $data['country_id'];
        $artisanProfile->state = $data['state'];
        $artisanProfile->postal_code = $data['postal_code'];
        
        // Update legacy fields for backward compatibility
        if ($data['city_id']) {
            $city = City::find($data['city_id']);
            if ($city) {
                $artisanProfile->city = $city->name;
            }
        }
        
        if ($data['country_id']) {
            $country = Country::find($data['country_id']);
            if ($country) {
                $artisanProfile->country = $country->name;
            }
        }
        
        $artisanProfile->save();
        
        return $artisanProfile;
    }

    /**
     * Update business information
     *
     * @param int $userId
     * @param array $data
     * @return ArtisanProfile
     */
    public function updateBusinessInfo(int $userId, array $data): ArtisanProfile
    {
        $artisanProfile = $this->findOrCreateByUserId($userId);
        
        $artisanProfile->business_name = $data['business_name'];
        $artisanProfile->business_registration_number = $data['business_registration_number'];
        $artisanProfile->insurance_details = $data['insurance_details'];
        $artisanProfile->save();
        
        return $artisanProfile;
    }

    /**
     * Update profile photo
     *
     * @param int $userId
     * @param $photoFile
     * @return string|null Path to the stored file or null on failure
     */
    public function updateProfilePhoto(int $userId, $photoFile): ?string
    {
        try {
            $artisanProfile = $this->findOrCreateByUserId($userId);
            
            // Delete old profile photo if exists
            if ($artisanProfile->profile_photo) {
                Storage::disk('public')->delete($artisanProfile->profile_photo);
            }
            
            // Store new photo
            $path = $photoFile->store('profile-photos', 'public');
            $artisanProfile->profile_photo = $path;
            $artisanProfile->save();
            
            Log::info('Profile photo updated successfully', [
                'user_id' => $userId,
                'path' => $path
            ]);
            
            return $path;
        } catch (\Exception $e) {
            Log::error('Error updating profile photo: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update artisan categories
     *
     * @param int $artisanProfileId
     * @param array $categoryIds
     * @return void
     */
    public function updateCategories(int $artisanProfileId, array $categoryIds): void
    {
        $artisanProfile = ArtisanProfile::find($artisanProfileId);
        if ($artisanProfile) {
            $artisanProfile->categories()->sync($categoryIds);
        }
    }

    /**
     * Get work experiences for an artisan profile
     *
     * @param int $artisanProfileId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWorkExperiences(int $artisanProfileId)
    {
        return WorkExperience::where('artisan_profile_id', $artisanProfileId)->get();
    }

    /**
     * Get certifications for an artisan profile
     *
     * @param int $artisanProfileId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCertifications(int $artisanProfileId)
    {
        return Certification::where('artisan_profile_id', $artisanProfileId)->get();
    }
}