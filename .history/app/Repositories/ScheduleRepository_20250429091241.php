<?php

namespace App\Repositories;

use App\Models\Availability;
use App\Models\ArtisanProfile;
use App\Repositories\Interfaces\ScheduleRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    /**
     * Get all availabilities for an artisan profile within a date range
     *
     * @param int $artisanProfileId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return Collection
     */
    public function getAvailabilitiesInDateRange(int $artisanProfileId, Carbon $startDate, Carbon $endDate): Collection
    {
        return Availability::where('artisan_profile_id', $artisanProfileId)
            ->whereBetween('date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ])
            ->get();
    }

    /**
     * Format availabilities grouped by date
     *
     * @param Collection $availabilities
     * @return array
     */
    public function formatAvailabilitiesByDate(Collection $availabilities): array
    {
        $formattedAvailabilities = [];

        foreach ($availabilities as $availability) {
            // Use the string format of the date as the key
            $dateKey = $availability->date->format('Y-m-d');

            if (!isset($formattedAvailabilities[$dateKey])) {
                $formattedAvailabilities[$dateKey] = [];
            }

            $formattedAvailabilities[$dateKey][] = [
                'id' => $availability->id,
                'start_time' => Carbon::parse($availability->start_time)->format('H:i'),
                'end_time' => Carbon::parse($availability->end_time)->format('H:i'),
                'status' => $availability->status,
            ];
        }

        return $formattedAvailabilities;
    }

    /**
     * Check for overlapping availabilities
     *
     * @param int $artisanProfileId
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    public function hasOverlappingAvailabilities(int $artisanProfileId, string $date, string $startTime, string $endTime): bool
    {
        return Availability::where('artisan_profile_id', $artisanProfileId)
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();
    }

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
    public function createAvailability(int $artisanProfileId, string $date, string $startTime, string $endTime, string $status = 'available'): Availability
    {
        return Availability::create([
            'artisan_profile_id' => $artisanProfileId,
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $status,
        ]);
    }

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
    public function createWeeklyAvailabilities(int $artisanProfileId, Carbon $startDate, Carbon $endDate, string $startTime, string $endTime, string $status = 'available'): int
    {
        $currentDate = $startDate->copy();
        $created = 0;

        while ($currentDate <= $endDate) {
            $this->createAvailability(
                $artisanProfileId,
                $currentDate->format('Y-m-d'),
                $startTime,
                $endTime,
                $status
            );

            $created++;
            $currentDate->addWeek();
        }

        return $created;
    }

    /**
     * Find an availability by ID for a specific artisan profile
     *
     * @param int $availabilityId
     * @param int $artisanProfileId
     * @return Availability|null
     */
    public function findAvailabilityForArtisan(int $availabilityId, int $artisanProfileId): ?Availability
    {
        return Availability::where('id', $availabilityId)
            ->where('artisan_profile_id', $artisanProfileId)
            ->first();
    }

    /**
     * Delete an availability
     *
     * @param Availability $availability
     * @return bool
     */
    public function deleteAvailability(Availability $availability): bool
    {
        return $availability->delete();
    }

    /**
     * Get or create artisan profile for user
     *
     * @param int $userId
     * @return ArtisanProfile|null
     */
    public function getOrCreateArtisanProfile(int $userId): ?ArtisanProfile
    {
        try {
            // Get or create artisan profile
            $artisanProfile = ArtisanProfile::where('user_id', $userId)->first();

            if (!$artisanProfile) {
                // Create a basic artisan profile if none exists
                $artisanProfile = ArtisanProfile::create([
                    'user_id' => $userId
                ]);
            }

            return $artisanProfile;
        } catch (\Exception $e) {
            Log::error('Failed to get or create artisan profile', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);
            return null;
        }
    }
}
