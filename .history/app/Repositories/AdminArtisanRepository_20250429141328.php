<?php

namespace App\Repositories;

use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
use App\Repositories\Interfaces\AdminArtisanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class AdminArtisanRepository implements AdminArtisanRepositoryInterface
{
    /**
     * Get paginated artisans with filters
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
     * Get artisan by ID with relationships
     *
     * @param int $id
     * @return User|null
     */
    public function getArtisanById(int $id): ?User
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
        ])->find($id);
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
     * Get artisan statistics
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

    /**
     * Find or create artisan profile
     *
     * @param int $userId
     * @return ArtisanProfile
     */
    public function findOrCreateArtisanProfile(int $userId): ArtisanProfile
    {
        $profile = ArtisanProfile::where('user_id', $userId)->first();
        
        if (!$profile) {
            $profile = ArtisanProfile::create([
                'user_id' => $userId,
            ]);
        }
        
        return $profile;
    }

    /**
     * Get artisan with services
     *
     * @param int $id
     * @return User|null
     */
    public function getArtisanWithServices(int $id): ?User
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'artisan');
        })->with(['artisanProfile.services'])->find($id);
    }
}