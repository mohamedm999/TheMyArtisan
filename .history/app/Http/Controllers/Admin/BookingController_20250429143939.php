<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\BookingRepositoryInterface;


class BookingController extends Controller
{
    /**
     * The booking repository instance.
     *
     * @var BookingRepositoryInterface
     */
    protected $bookingRepository;

    /**
     * Create a new controller instance.
     *
     * @param BookingRepositoryInterface $bookingRepository
     * @return void
     */
    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Display a listing of bookings.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $bookings = $this->bookingRepository->getFilteredBookingsForAdmin($request);
        $stats = $this->bookingRepository->getBookingStatisticsForAdmin();

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Display the specified booking.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $booking = $this->bookingRepository->getBookingWithAllRelations($id);

        if (!$booking) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Booking not found.');
        }

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update the booking status.
     *
     * @param Request $request
     * @param Booking $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
        ]);

        $result = $this->bookingRepository->updateBookingStatusByAdmin($booking, $request->status);

        if ($result) {
            return redirect()->back()->with('success', 'Booking status updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update booking status.');
        }
    }
}
