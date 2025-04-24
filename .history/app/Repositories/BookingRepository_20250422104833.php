<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository implements BookingRepositoryInterface
{
    /**
     * Get bookings by artisan profile ID and status
     *
     * @param int $artisanProfileId
     * @param string|null $status
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getBookingsByArtisanAndStatus(int $artisanProfileId, ?string $status = null): LengthAwarePaginator
    {
        $query = Booking::where('artisan_profile_id', $artisanProfileId)
            ->with(['clientProfile.user', 'service']);

        // Only filter by status if it's not 'all'
        if ($status !== null && $status !== 'all') {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }
    
    /**
     * Get booking counts by artisan profile ID grouped by status
     *
     * @param int $artisanProfileId
     * @return array
     */
    public function getBookingCountsByStatus(int $artisanProfileId): array
    {
        return [
            'pending' => Booking::where('artisan_profile_id', $artisanProfileId)->where('status', 'pending')->count(),
            'confirmed' => Booking::where('artisan_profile_id', $artisanProfileId)->where('status', 'confirmed')->count(),
            'in_progress' => Booking::where('artisan_profile_id', $artisanProfileId)->where('status', 'in_progress')->count(),
            'completed' => Booking::where('artisan_profile_id', $artisanProfileId)->where('status', 'completed')->count(),
            'cancelled' => Booking::where('artisan_profile_id', $artisanProfileId)->where('status', 'cancelled')->count(),
        ];
    }
    
    /**
     * Get a booking by ID and artisan profile ID
     *
     * @param int $bookingId
     * @param int $artisanProfileId
     * @return Booking
     */
    public function getBookingByIdAndArtisan(int $bookingId, int $artisanProfileId): ?Booking
    {
        return Booking::where('artisan_profile_id', $artisanProfileId)
            ->where('id', $bookingId)
            ->with(['clientProfile.user', 'service'])
            ->first();
    }
    
    /**
     * Update a booking status
     *
     * @param Booking $booking
     * @param string $status
     * @return bool
     */
    public function updateBookingStatus(Booking $booking, string $status): bool
    {
        return $booking->update([
            'status' => $status
        ]);
    }
}