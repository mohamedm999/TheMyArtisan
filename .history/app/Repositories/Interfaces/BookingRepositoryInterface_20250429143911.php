<?php

namespace App\Repositories\Interfaces;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

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

    /**
     * Get filtered bookings for admin view
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getFilteredBookingsForAdmin(Request $request): LengthAwarePaginator;

    /**
     * Get booking with all relations by ID
     *
     * @param int $bookingId
     * @return Booking|null
     */
    public function getBookingWithAllRelations(int $bookingId): ?Booking;

    /**
     * Update booking status for admin
     *
     * @param Booking $booking
     * @param string $status
     * @return bool
     */
    public function updateBookingStatusByAdmin(Booking $booking, string $status): bool;

    /**
     * Get booking statistics for admin dashboard
     *
     * @return array
     */
    public function getBookingStatisticsForAdmin(): array;
}
