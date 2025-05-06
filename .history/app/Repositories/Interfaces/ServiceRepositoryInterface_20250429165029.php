<?php

namespace App\Repositories\Interfaces;

use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ServiceRepositoryInterface
{
    /**
     * Get all services for an artisan
     *
     * @param int $artisanProfileId
     * @return Collection
     */
    public function getArtisanServices(int $artisanProfileId): Collection;

    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection;

    /**
     * Create a new service for an artisan
     *
     * @param array $data
     * @param int $artisanProfileId
     * @return Service
     */
    public function createService(array $data, int $artisanProfileId): Service;

    /**
     * Update an existing service
     *
     * @param Service $service
     * @param array $data
     * @return bool
     */
    public function updateService(Service $service, array $data): bool;

    /**
     * Delete a service
     *
     * @param Service $service
     * @return bool
     */
    public function deleteService(Service $service): bool;

    /**
     * Find a service by ID for a specific artisan profile
     *
     * @param int $serviceId
     * @param int $artisanProfileId
     * @return Service|null
     */
    public function findServiceForArtisan(int $serviceId, int $artisanProfileId): ?Service;

    /**
     * Get or create artisan profile for user
     *
     * @param int $userId
     * @return ArtisanProfile
     */
    public function getOrCreateArtisanProfile(int $userId): ArtisanProfile;

    /**
     * Handle image upload for a service
     *
     * @param Request $request
     * @param Service|null $service
     * @return string|null
     */
    public function handleImageUpload(Request $request, ?Service $service = null): ?string;

    /**
     * Get all services with filters for admin
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllServicesForAdmin(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    /**
     * Get active categories
     *
     * @return Collection
     */
    public function getActiveCategories(): Collection;

    /**
     * Get all artisans with their profiles
     *
     * @return Collection
     */
    public function getAllArtisansWithProfiles(): Collection;

    /**
     * Find service by ID
     *
     * @param int $id
     * @return Service|null
     */
    public function findServiceById(int $id): ?Service;

    /**
     * Check if service has bookings
     *
     * @param Service $service
     * @return bool
     */
    public function hasBookings(Service $service): bool;
}
