<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = $request->status ?? 'pending';
        $user = auth()->user();

        // Get bookings based on status
        $bookings = $user->bookings()
            ->with(['customer', 'service'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get counts for each status
        $counts = [
            'pending' => $user->bookings()->where('status', 'pending')->count(),
            'confirmed' => $user->bookings()->where('status', 'confirmed')->count(),
            'in_progress' => $user->bookings()->where('status', 'in_progress')->count(),
            'completed' => $user->bookings()->where('status', 'completed')->count(),
            'cancelled' => $user->bookings()->where('status', 'cancelled')->count(),
        ];

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
        // Check if this booking belongs to the authenticated artisan
        if ($booking->artisan_id !== auth()->id()) {
            return back()->with('error', 'You are not authorized to update this booking.');
        }

        $booking->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Booking status updated successfully.');
    }
}
