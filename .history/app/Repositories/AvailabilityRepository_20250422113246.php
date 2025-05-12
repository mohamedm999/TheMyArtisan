<?php

namespace App\Repositories;

use App\Models\Availability;
use App\Repositories\Interfaces\AvailabilityRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    /**
     * Get availabilities for an artisan profile between date range
     *
     * @param int $artisanProfileId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return Collection
     */
    public function getAvailabilitiesByDateRange(int $artisanProfileId, Carbon $startDate, Carbon $endDate): Collection
    {
        return Availability::where('artisan_profile_id', $artisanProfileId)
            ->whereBetween('date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
    }
    
    /**
     * Check if there are overlapping availabilities for a given time slot
     *
     * @param int $artisanProfileId
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    public function checkOverlappingAvailabilities(int $artisanProfileId, string $date, string $startTime, string $endTime): bool
    {
        return Availability::where('artisan_profile_id', $artisanProfileId)
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    // New slot starts during an existing slot
                    $q->where('start_time', '<=', $startTime)
                       ->where('end_time', '>', $startTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // New slot ends during an existing slot
                    $q->where('start_time', '<', $endTime)
                       ->where('end_time', '>=', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // New slot contains an existing slot
                    $q->where('start_time', '>=', $startTime)
                       ->where('end_time', '<=', $endTime);
                });
            })
            ->exists();
    }
    
    /**
     * Create a new availability
     *
     * @param array $data
     * @return Availability
     */
    public function create(array $data): Availability
    {
        return Availability::create($data);
    }
    
    /**
     * Find availability by ID and artisan profile ID
     *
     * @param int $id
     * @param int $artisanProfileId
     * @return Availability|null
     */
    public function findByIdAndArtisanProfile(int $id, int $artisanProfileId): ?Availability
    {
        return Availability::where('id', $id)
            ->where('artisan_profile_id', $artisanProfileId)
            ->first();
    }
    
    /**
     * Delete an availability
     *
     * @param Availability $availability
     * @return bool
     */
    public function delete(Availability $availability): bool
    {
        return $availability->delete();
    }
}