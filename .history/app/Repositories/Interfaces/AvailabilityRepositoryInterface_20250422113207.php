<?php

namespace App\Repositories\Interfaces;

use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface AvailabilityRepositoryInterface
{
    /**
     * Get availabilities for an artisan profile between date range
     *
     * @param int $artisanProfileId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return Collection
     */
    public function getAvailabilitiesByDateRange(int $artisanProfileId, Carbon $startDate, Carbon $endDate): Collection;
    
    /**
     * Check if there are overlapping availabilities for a given time slot
     *
     * @param int $artisanProfileId
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    public function checkOverlappingAvailabilities(int $artisanProfileId, string $date, string $startTime, string $endTime): bool;
    
    /**
     * Create a new availability
     *
     * @param array $data
     * @return Availability
     */
    public function create(array $data): Availability;
    
    /**
     * Find availability by ID and artisan profile ID
     *
     * @param int $id
     * @param int $artisanProfileId
     * @return Availability|null
     */
    public function findByIdAndArtisanProfile(int $id, int $artisanProfileId): ?Availability;
    
    /**
     * Delete an availability
     *
     * @param Availability $availability
     * @return bool
     */
    public function delete(Availability $availability): bool;
}