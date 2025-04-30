<?php

namespace App\Repositories\Interfaces;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookingRepositoryInterface
{
    /**
     * Get bookings by artisan profile ID and status
     *
     * @param int $artisanProfileId
     * @param string|null $status
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getBookingsByArtisanAndStatus(int $artisanProfileId, ?string $status = null): LengthAwarePaginator;
    
    /**
     * Get booking counts by artisan profile ID grouped by status
     *
     * @param int $artisanProfileId
     * @return array
     */
    public function getBookingCountsByStatus(int $artisanProfileId): array;
    
    /**
     * Get a booking by ID and artisan profile ID
     *
     * @param int $bookingId
     * @param int $artisanProfileId
     * @return Booking
     */
    public function getBookingByIdAndArtisan(int $bookingId, int $artisanProfileId): ?Booking;
    
    /**
     * Update a booking status
     *
     * @param Booking $booking
     * @param string $status
     * @return bool
     */
    public function updateBookingStatus(Booking $booking, string $status): bool;
}