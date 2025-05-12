<?php

namespace App\Repositories\Interfaces;

use App\Models\ArtisanProfile;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AdminArtisanRepositoryInterface
{
    /**
     * Get paginated artisans with filters
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getFilteredArtisans(array $filters = []): LengthAwarePaginator;
    
    /**
     * Get artisan by ID with relationships
     *
     * @param int $id
     * @return User|null
     */
    public function getArtisanById(int $id): ?User;
    
    /**
     * Update artisan profile status
     *
     * @param int $userId
     * @param string $status
     * @return ArtisanProfile|null
     */
    public function updateArtisanStatus(int $userId, string $status): ?ArtisanProfile;
    
    /**
     * Get artisan statistics
     *
     * @return array
     */
    public function getArtisanStatistics(): array;
    
    /**
     * Create artisan profiles for users who don't have them
     *
     * @return int Number of profiles created
     */
    public function createMissingArtisanProfiles(): int;
    
    /**
     * Get all active countries
     *
     * @return Collection
     */
    public function getAllActiveCountries(): Collection;
    
    /**
     * Get all active categories
     *
     * @return Collection
     */
    public function getAllActiveCategories(): Collection;
    
    /**
     * Find or create artisan profile
     *
     * @param int $userId
     * @return ArtisanProfile
     */
    public function findOrCreateArtisanProfile(int $userId): ArtisanProfile;
    
    /**
     * Get artisan with services
     *
     * @param int $id
     * @return User|null
     */
    public function getArtisanWithServices(int $id): ?User;
}