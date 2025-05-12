<?php

namespace App\Repositories;

use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use App\Models\City;
use App\Models\Country;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Get filtered artisans with pagination for admin
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getFilteredArtisans(array $filters = []): LengthAwarePaginator
    {
        // First create base query for artisan users
        $query = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with([
            'artisanProfile',
            'artisanProfile.categories',
            'artisanProfile.services',
            'artisanProfile.reviews',
            'artisanProfile.city',
            'artisanProfile.country',
        ]);

        // Apply search filter
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('artisanProfile', function ($q) use ($search) {
                        $q->where('specialty', 'like', "%{$search}%");
                    });
            });
        }

        // Apply status filter
        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->whereHas('artisanProfile', function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            });
        }

        // Apply country filter
        if (isset($filters['country']) && !empty($filters['country'])) {
            $query->whereHas('artisanProfile', function ($q) use ($filters) {
                $q->where('country_id', $filters['country']);
            });
        }

        // Apply category filter
        if (isset($filters['category']) && !empty($filters['category'])) {
            $query->whereHas('artisanProfile.categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category']);
            });
        }

        // Return paginated results
        return $query->paginate(10);
    }

    /**
     * Get artisan statistics for admin dashboard
     *
     * @return array
     */
    public function getArtisanStatistics(): array
    {
        return [
            'total' => User::whereHas('roles', function ($query) {
                $query->where('name', 'artisan');
            })->count(),
            'pending' => User::whereHas('roles', function ($query) {
                $query->where('name', 'artisan');
            })->whereHas('artisanProfile', function ($q) {
                $q->where('status', 'pending');
            })->count(),
            'approved' => User::whereHas('roles', function ($query) {
                $query->where('name', 'artisan');
            })->whereHas('artisanProfile', function ($q) {
                $q->where('status', 'approved');
            })->count(),
            'rejected' => User::whereHas('roles', function ($query) {
                $query->where('name', 'artisan');
            })->whereHas('artisanProfile', function ($q) {
                $q->where('status', 'rejected');
            })->count(),
        ];
    }

    /**
     * Create artisan profiles for users who don't have them
     *
     * @return int Number of profiles created
     */
    public function createMissingArtisanProfiles(): int
    {
        $created = 0;
        
        $artisanUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->get();

        foreach ($artisanUsers as $user) {
            if (!$user->artisanProfile) {
                // Create a default artisan profile for this user with only fillable fields
                ArtisanProfile::create([
                    'user_id' => $user->id,
                ]);
                $created++;
            }
        }
        
        return $created;
    }

    /**
     * Get artisan user by ID with all relationships for admin view
     *
     * @param int $userId
     * @return User|null
     */
    public function getArtisanWithDetails(int $userId): ?User
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with([
            'artisanProfile',
            'artisanProfile.categories',
            'artisanProfile.services',
            'artisanProfile.reviews',
            'artisanProfile.bookings',
            'artisanProfile.city',
            'artisanProfile.country',
            'artisanProfile.workExperiences',
            'artisanProfile.certifications',
        ])->find($userId);
    }

    /**
     * Update artisan profile status
     *
     * @param int $userId
     * @param string $status
     * @return ArtisanProfile|null
     */
    public function updateArtisanStatus(int $userId, string $status): ?ArtisanProfile
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                return null;
            }

            $profile = $user->artisanProfile;
            if (!$profile) {
                return null;
            }

            $profile->status = $status;
            $profile->save();

            return $profile;
        } catch (\Exception $e) {
            Log::error('Error updating artisan status', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get artisan user with services
     *
     * @param int $userId
     * @return User|null
     */
    public function getArtisanWithServices(int $userId): ?User
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with(['artisanProfile.services'])->find($userId);
    }

    /**
     * Get all active countries
     * 
     * @return Collection
     */
    public function getAllActiveCountries(): Collection
    {
        return Country::where('is_active', true)->orderBy('name')->get();
    }

    /**
     * Get all active categories
     * 
     * @return Collection
     */
    public function getAllActiveCategories(): Collection
    {
        return Category::where('is_active', true)->orderBy('name')->get();
    }
}
