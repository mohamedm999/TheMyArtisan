<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\ArtisanProfile;
use App\Services\PointsService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingController extends Controller
{
    /**
     * Points service instance.
     *
     * @var \App\Services\PointsService
     */
    protected $pointsService;

    /**
     * Booking repository instance.
     *
     * @var \App\Repositories\Interfaces\BookingRepositoryInterface
     */
    protected $bookingRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\PointsService  $pointsService
     * @param  \App\Repositories\Interfaces\BookingRepositoryInterface  $bookingRepository
     * @return void
     */
    public function __construct(
        PointsService $pointsService,
        BookingRepositoryInterface $bookingRepository
    ) {
        $this->pointsService = $pointsService;
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Display a listing of the bookings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = $request->status ?? 'pending';
        $user = Auth::user();
        $artisanProfile = $user->artisanProfile;

        if (!$artisanProfile) {
            return redirect()->route('artisan.profile')
                ->with('error', 'Please complete your artisan profile first.');
        }

        // Get bookings using repository pattern
        $bookings = $this->bookingRepository->getBookingsByArtisanAndStatus($artisanProfile->id, $status);

        // Get counts for each status using repository
        $counts = $this->bookingRepository->getBookingCountsByStatus($artisanProfile->id);

        return view('artisan.bookings', compact('bookings', 'status', 'counts'));
    }

    /**
     * Update the specified booking status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Booking $booking)
    {
        $artisanProfile = Auth::user()->artisanProfile;

        // Check if this booking belongs to the authenticated artisan
        if ($booking->artisan_profile_id !== $artisanProfile->id) {
            return back()->with('error', 'You are not authorized to update this booking.');
        }

        $oldStatus = $booking->status;
        $newStatus = $request->status;

        // Update booking status using repository
        $this->bookingRepository->updateBookingStatus($booking, $newStatus);

        // Award points if the booking is being marked as completed
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            // Get the client user
            $clientUser = $booking->clientProfile->user;

            // Award points to the client
            $result = $this->pointsService->awardBookingPoints($booking);

            $pointsMessage = $result ? " Client has been awarded points for this booking." : "";
        } else {
            $pointsMessage = "";
        }

        $statusMessage = ucfirst($request->status);
        if ($request->status == 'confirmed') {
            $message = "Booking confirmed successfully. The client has been notified.";
        } elseif ($request->status == 'in_progress') {
            $message = "Booking marked as in progress. The client has been notified.";
        } elseif ($request->status == 'completed') {
            $message = "Booking marked as completed. The client has been notified and can now leave a review." . $pointsMessage;
        } elseif ($request->status == 'cancelled') {
            $message = "Booking cancelled successfully. The client has been notified.";
        } else {
            $message = "Booking status updated to {$statusMessage}.";
        }

        return back()->with('success', $message);
    }

    /**
     * Show the details of a specific booking.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $artisanProfile = Auth::user()->artisanProfile;

        if (!$artisanProfile) {
            return redirect()->route('artisan.profile')
                ->with('error', 'Please complete your artisan profile first.');
        }

        // Get booking by ID using repository
        $booking = $this->bookingRepository->getBookingByIdAndArtisan($id, $artisanProfile->id);

        if (!$booking) {
            abort(404);
        }

        return view('artisan.bookings.show', compact('booking'));
    }
}
