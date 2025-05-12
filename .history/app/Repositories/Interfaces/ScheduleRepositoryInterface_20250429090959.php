<?php

namespace App\Repositories\Interfaces;

use App\Models\Availability;
use App\Models\ArtisanProfile;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ScheduleRepositoryInterface
{
    /**
     * Get all availabilities for an artisan profile within a date range
     *
     * @param int $artisanProfileId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return Collection
     */
    public function getAvailabilitiesInDateRange(int $artisanProfileId, Carbon $startDate, Carbon $endDate): Collection;

    /**
     * Format availabilities grouped by date
     *
     * @param Collection $availabilities
     * @return array
     */
    public function formatAvailabilitiesByDate(Collection $availabilities): array;

    /**
     * Check for overlapping availabilities
     *
     * @param int $artisanProfileId
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    public function hasOverlappingAvailabilities(int $artisanProfileId, string $date, string $startTime, string $endTime): bool;

    /**
     * Create a new availability
     *
     * @param int $artisanProfileId
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @param string $status
     * @return Availability
     */
    public function createAvailability(int $artisanProfileId, string $date, string $startTime, string $endTime, string $status = 'available'): Availability;

    /**
     * Create multiple weekly recurring availabilities
     *
     * @param int $artisanProfileId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param string $startTime
     * @param string $endTime
     * @param string $status
     * @return int Number of created availabilities
     */
    public function createWeeklyAvailabilities(int $artisanProfileId, Carbon $startDate, Carbon $endDate, string $startTime, string $endTime, string $status = 'available'): int;

    /**
     * Find an availability by ID for a specific artisan profile
     *
     * @param int $availabilityId
     * @param int $artisanProfileId
     * @return Availability|null
     */
    public function findAvailabilityForArtisan(int $availabilityId, int $artisanProfileId): ?Availability;

    /**
     * Delete an availability
     *
     * @param Availability $availability
     * @return bool
     */
    public function deleteAvailability(Availability $availability): bool;

    /**
     * Get or create artisan profile for user
     * 
     * @param int $userId
     * @return ArtisanProfile
     */
    public function getOrCreateArtisanProfile(int $userId): ?ArtisanProfile;
}