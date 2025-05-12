<?php

namespace App\Repositories\Interfaces;

use App\Models\ArtisanProfile;
use App\Models\Certification;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArtisanProfileRepositoryInterface
{
    /**
     * Get artisan profile by user ID
     *
     * @param int $userId
     * @return ArtisanProfile|null
     */
    public function getByUserId(int $userId);

    /**
     * Find or create an artisan profile for a user
     *
     * @param int $userId
     * @return ArtisanProfile
     */
    public function findOrCreateByUserId(int $userId): ArtisanProfile;

    /**
     * Update professional information
     *
     * @param int $userId
     * @param array $data
     * @return ArtisanProfile
     */
    public function updateProfessionalInfo(int $userId, array $data): ArtisanProfile;

    /**
     * Add work experience
     *
     * @param int $artisanProfileId
     * @param array $data
     * @return WorkExperience
     */
    public function addWorkExperience(int $artisanProfileId, array $data): WorkExperience;

    /**
     * Add certification
     *
     * @param int $artisanProfileId
     * @param array $data
     * @return Certification
     */
    public function addCertification(int $artisanProfileId, array $data): Certification;

    /**
     * Delete certification
     *
     * @param int $certificationId
     * @param int $artisanProfileId
     * @return bool
     */
    public function deleteCertification(int $certificationId, int $artisanProfileId): bool;

    /**
     * Update contact information
     *
     * @param int $userId
     * @param array $data
     * @return ArtisanProfile
     */
    public function updateContactInfo(int $userId, array $data): ArtisanProfile;

    /**
     * Update business information
     *
     * @param int $userId
     * @param array $data
     * @return ArtisanProfile
     */
    public function updateBusinessInfo(int $userId, array $data): ArtisanProfile;

    /**
     * Update profile photo
     *
     * @param int $userId
     * @param $photoFile
     * @return string|null Path to the stored file or null on failure
     */
    public function updateProfilePhoto(int $userId, $photoFile): ?string;

    /**
     * Update artisan categories
     *
     * @param int $artisanProfileId
     * @param array $categoryIds
     * @return void
     */
    public function updateCategories(int $artisanProfileId, array $categoryIds): void;

    /**
     * Get work experiences for an artisan profile
     *
     * @param int $artisanProfileId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWorkExperiences(int $artisanProfileId);

    /**
     * Get certifications for an artisan profile
     *
     * @param int $artisanProfileId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCertifications(int $artisanProfileId);

    /**
     * Get filtered and paginated artisans for admin
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getFilteredArtisans(array $filters = []): LengthAwarePaginator;

    /**
     * Get artisan statistics for admin dashboard
     *
     * @return array
     */
    public function getArtisanStatistics(): array;

    /**
     * Get artisan with all relationships by user ID
     *
     * @param int $userId
     * @return mixed
     */
    public function getArtisanWithAllRelations(int $userId);

    /**
     * Update artisan status
     *
     * @param int $artisanProfileId
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $artisanProfileId, string $status): bool;

    /**
     * Export artisans data
     *
     * @param array $filters
     * @return array
     */
    public function exportArtisans(array $filters = []): array;
}
