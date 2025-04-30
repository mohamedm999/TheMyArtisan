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
        $reviews = Review::where('client_profile_id', $user->clientProfile->client_profile_id)
            ->with(['artisanProfile.user', 'service', 'booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.reviews.index', compact('reviews'));
    }

    /**
     * Show the form to create a new review.
     *
     * @param  int  $bookingId
     * @return \Illuminate\View\View
     */
    public function create($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('client_profile_id', Auth::user()->clientProfile->client_profile_id)
            ->where('status', 'completed')
            ->firstOrFail();

        // Check if a review already exists
        $existingReview = Review::where('booking_id', $bookingId)->first();
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
     * @param  int  $bookingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $bookingId)
    {
        try {
            // Validate input first
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|min:10|max:1000',
            ]);

            $user = Auth::user();
            if (!$user || !$user->clientProfile) {
                return redirect()->route('login')
                    ->with('error', 'You must be logged in as a client to submit a review.');
            }

            $booking = Booking::where('id', $bookingId)
                ->where('client_profile_id', $user->clientProfile->client_profile_id)
                ->where('status', 'completed')
                ->first();

            if (!$booking) {
                return redirect()->route('client.bookings.index')
                    ->with('error', 'Unable to find a completed booking with this ID.');
            }

            // Check if a review already exists
            $existingReview = Review::where('booking_id', $bookingId)->first();
            if ($existingReview) {
                return redirect()->route('client.bookings.show', $booking->id)
                    ->with('error', 'You have already reviewed this booking.');
            }

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
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Review submission error: ' . $e->getMessage());

            // Return with error
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while submitting your review. Please try again.');
        }
    }
}
