<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;
use App\Models\ClientProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        // Debug the incoming parameter
        Log::info('Review create method called with ID: ' . $id);

        try {
            // Get the client profile ID correctly
            $clientProfileId = ClientProfile::where('user_id', Auth::id())->first()->id;

            $booking = Booking::where('id', $id)
                ->where('client_profile_id', $clientProfileId)
                ->where('status', 'completed')
                ->firstOrFail();

            // Check if a review already exists
            $existingReview = Review::where('booking_id', $id)->first();
            if ($existingReview) {
                return redirect()->route('client.bookings.show', $id)
                    ->with('error', 'You have already reviewed this booking.');
            }

            return view('client.reviews.create', compact('booking'));
        } catch (\Exception $e) {
            Log::error('Error in review creation: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->route('client.bookings.index')
                ->with('error', 'Unable to find the booking or you do not have permission to review it.');
        }
    }

    /**
     * Store a new review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id)
    {
        // Debug the incoming parameter and data
        Log::info('Review store method called with ID: ' . $id);
        Log::info('Review data: ' . json_encode($request->all()));

        try {
            // Get the client profile ID correctly
            $clientProfileId = ClientProfile::where('user_id', Auth::id())->first()->id;

            $booking = Booking::where('id', $id)
                ->where('client_profile_id', $clientProfileId)
                ->where('status', 'completed')
                ->firstOrFail();

            // Check if a review already exists
            $existingReview = Review::where('booking_id', $id)->first();
            if ($existingReview) {
                return redirect()->route('client.bookings.show', $id)
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

            return redirect()->route('client.bookings.show', $id)
                ->with('success', 'Your review has been submitted. Thank you for your feedback!');
        } catch (\Exception $e) {
            Log::error('Error in review submission: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            // Return a more helpful error message
            return back()->withInput()
                ->with('error', 'Unable to submit your review: ' . $e->getMessage());
        }
    }
}
