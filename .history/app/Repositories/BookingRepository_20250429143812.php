<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    /**
     * Get filtered bookings for admin view
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getFilteredBookingsForAdmin(Request $request): LengthAwarePaginator
    {
        $query = Booking::with(['clientProfile.user', 'artisanProfile.user', 'service']);

        // Filter by artisan if provided
        if ($request->has('artisan_id')) {
            $query->whereHas('artisanProfile', function ($q) use ($request) {
                $q->where('user_id', $request->artisan_id);
            });
        }

        // Filter by client if provided
        if ($request->has('client_id')) {
            $query->whereHas('clientProfile', function ($q) use ($request) {
                $q->where('user_id', $request->client_id);
            });
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        // Search by service name or booking reference
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                  ->orWhereHas('service', function($sq) use ($search) {
                      $sq->where('name', 'like', "%$search%");
                  })
                  ->orWhereHas('artisanProfile.user', function($sq) use ($search) {
                      $sq->where('firstname', 'like', "%$search%")
                        ->orWhere('lastname', 'like', "%$search%");
                  })
                  ->orWhereHas('clientProfile.user', function($sq) use ($search) {
                      $sq->where('firstname', 'like', "%$search%")
                        ->orWhere('lastname', 'like', "%$search%");
                  });
            });
        }

        // Sort
        $sortField = $request->get('sort_by', 'booking_date');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($request->get('per_page', 10))
            ->withQueryString();
    }

    /**
     * Get booking with all relations by ID
     *
     * @param int $bookingId
     * @return Booking|null
     */
    public function getBookingWithAllRelations(int $bookingId): ?Booking
    {
        return Booking::with([
            'clientProfile.user',
            'artisanProfile.user',
            'service',
            'review',
            'payments',
            'messages'
        ])->find($bookingId);
    }

    /**
     * Update booking status for admin
     *
     * @param Booking $booking
     * @param string $status
     * @return bool
     */
    public function updateBookingStatusByAdmin(Booking $booking, string $status): bool
    {
        try {
            $oldStatus = $booking->status;
            $result = $booking->update([
                'status' => $status,
                'status_updated_at' => now(),
                'admin_notes' => $booking->admin_notes . "\nStatus changed from {$oldStatus} to {$status} by admin on " . now()->format('Y-m-d H:i:s')
            ]);
            
            Log::info('Admin updated booking status', [
                'booking_id' => $booking->id,
                'old_status' => $oldStatus,
                'new_status' => $status
            ]);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Error updating booking status by admin', [
                'booking_id' => $booking->id,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Get booking statistics for admin dashboard
     *
     * @return array
     */
    public function getBookingStatisticsForAdmin(): array
    {
        return [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'in_progress' => Booking::where('status', 'in_progress')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'today' => Booking::whereDate('created_at', now())->count(),
            'this_week' => Booking::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'this_month' => Booking::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count()
        ];
    }
}
