<?php

namespace App\Observers;

use App\Models\Booking;
use App\Services\PointsService;

class BookingObserver
{
    /**
     * The points service instance.
     *
     * @var PointsService
     */
    protected $pointsService;

    /**
     * Create a new observer instance.
     *
     * @param  PointsService  $pointsService
     * @return void
     */
    public function __construct(PointsService $pointsService)
    {
        $this->pointsService = $pointsService;
    }

    /**
     * Handle the Booking "created" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function created(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "updated" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function updated(Booking $booking)
    {
        // Check if the booking was just marked as completed
        if ($booking->status === 'completed' && $booking->getOriginal('status') !== 'completed') {
            $this->pointsService->awardBookingPoints($booking);
        }
    }

    /**
     * Handle the Booking "deleted" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function deleted(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function restored(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function forceDeleted(Booking $booking)
    {
        //
    }
}