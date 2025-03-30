<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the client's reviews.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $reviews = Review::where('client_profile_id', $user->id)
            ->with(['artisanProfile.user', 'service', 'booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.reviews.index', compact('reviews'));
    }

    /**
     * Show the form to create a new review.
     *
     * @param  int|Booking  $booking
     * @return \Illuminate\View\View
     */
    public function create($booking)
    {
        // If $booking is an ID and not a Booking instance, find the booking
        if (!($booking instanceof Booking)) {
            $booking = Booking::where('id', $booking)
                ->where('client_profile_id', Auth::user()->id)
                ->where('status', 'completed')
                ->firstOrFail();
        }

        // Check if a review already exists
        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return redirect()->route('client.bookings.show', $booking->id)
                ->with('error', 'You have already reviewed this booking.');
        }

        return view('client.reviews.create', compact('booking'));
    }

    /**
     * Store a new review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|Booking  $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $booking)
    {
        // If $booking is an ID and not a Booking instance, find the booking
        if (!($booking instanceof Booking)) {
            $booking = Booking::where('id', $booking)
                ->where('client_profile_id', Auth::user()->id)
                ->where('status', 'completed')
                ->firstOrFail();
        }

        // Check if a review already exists
        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return redirect()->route('client.bookings.show', $booking->id)
                ->with('error', 'You have already reviewed this booking.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'service_id' => $booking->service_id,
            'client_profile_id' => $booking->client_profile_id,
            'artisan_profile_id' => $booking->artisan_profile_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'published',
            'is_verified_purchase' => true,
        ]);

        return redirect()->route('client.bookings.show', $booking->id)
            ->with('success', 'Your review has been submitted. Thank you for your feedback!');
    }
}
