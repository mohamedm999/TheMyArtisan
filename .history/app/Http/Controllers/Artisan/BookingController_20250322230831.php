<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\ArtisanProfile;
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
        $user = Auth::user();
        $artisanProfile = $user->artisanProfile;

        if (!$artisanProfile) {
            return redirect()->route('artisan.profile')
                ->with('error', 'Please complete your artisan profile first.');
        }

        // Get bookings based on status
        $query = Booking::where('artisan_profile_id', $artisanProfile->id)
            ->with(['clientProfile.user', 'service']);

        // Only filter by status if it's not 'all'
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get counts for each status
        $counts = [
            'pending' => Booking::where('artisan_profile_id', $artisanProfile->id)->where('status', 'pending')->count(),
            'confirmed' => Booking::where('artisan_profile_id', $artisanProfile->id)->where('status', 'confirmed')->count(),
            'in_progress' => Booking::where('artisan_profile_id', $artisanProfile->id)->where('status', 'in_progress')->count(),
            'completed' => Booking::where('artisan_profile_id', $artisanProfile->id)->where('status', 'completed')->count(),
            'cancelled' => Booking::where('artisan_profile_id', $artisanProfile->id)->where('status', 'cancelled')->count(),
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
        $artisanProfile = Auth::user()->artisanProfile;

        // Check if this booking belongs to the authenticated artisan
        if ($booking->artisan_profile_id !== $artisanProfile->id) {
            return back()->with('error', 'You are not authorized to update this booking.');
        }

        $booking->update([
            'status' => $request->status
        ]);

        $statusMessage = ucfirst($request->status);
        if ($request->status == 'confirmed') {
            $message = "Booking confirmed successfully. The client has been notified.";
        } elseif ($request->status == 'in_progress') {
            $message = "Booking marked as in progress. The client has been notified.";
        } elseif ($request->status == 'completed') {
            $message = "Booking marked as completed. The client has been notified and can now leave a review.";
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

        $booking = Booking::where('artisan_profile_id', $artisanProfile->id)
            ->where('id', $id)
            ->with(['clientProfile.user', 'service'])
            ->firstOrFail();

        return view('artisan.bookings.show', compact('booking'));
    }
}
