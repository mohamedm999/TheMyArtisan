<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ArtisanProfile;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Store a newly created booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'artisan_profile_id' => 'required|exists:artisan_profiles,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        // Get the client profile ID from the authenticated user
        $clientProfile = Auth::user()->clientProfile;

        if (!$clientProfile) {
            return redirect()->back()->with('error', 'You need to complete your client profile before booking.');
        }

        // Create the booking
        $booking = Booking::create([
            'client_profile_id' => $clientProfile->id,
            'artisan_profile_id' => $request->artisan_profile_id,
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'status' => 'pending', // Default status is pending
            'notes' => $request->notes,
        ]);

        return redirect()->route('client.bookings.index')
            ->with('success', 'Booking request sent successfully! You will be notified once the artisan confirms your booking.');
    }

    /**
     * Display a listing of the user's bookings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientProfile = Auth::user()->clientProfile;

        if (!$clientProfile) {
            return redirect()->route('client.profile.create')
                ->with('error', 'Please complete your client profile first.');
        }

        $bookings = Booking::where('client_profile_id', $clientProfile->id)
            ->with(['artisanProfile.user', 'service'])
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return view('client.bookings.index', compact('bookings'));
    }

    /**
     * Display the specified booking.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clientProfile = Auth::user()->clientProfile;

        if (!$clientProfile) {
            return redirect()->route('client.profile.create')
                ->with('error', 'Please complete your client profile first.');
        }

        $booking = Booking::where('client_profile_id', $clientProfile->id)
            ->where('id', $id)
            ->with(['artisanProfile.user', 'service', 'review'])
            ->firstOrFail();

        return view('client.bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $clientProfile = Auth::user()->clientProfile;

        $booking = Booking::where('client_profile_id', $clientProfile->id)
            ->where('id', $id)
            ->where('status', '!=', 'completed')
            ->firstOrFail();

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('client.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}
