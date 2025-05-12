<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ArtisanProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewsController extends Controller
{
    /**
     * Display a listing of reviews for the authenticated artisan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter', 'all');
        $search = $request->input('search');

        $reviewsQuery = Review::where('artisan_profile_id', $user->artisanProfile->id)
            ->with(['client', 'service', 'booking'])
            ->orderBy('created_at', 'desc');

        // Filter reviews
        if ($filter === 'positive') {
            $reviewsQuery->where('rating', '>=', 4);
        } elseif ($filter === 'neutral') {
            $reviewsQuery->whereBetween('rating', [3, 3.9]);
        } elseif ($filter === 'negative') {
            $reviewsQuery->where('rating', '<', 3);
        } elseif ($filter === 'pending') {
            $reviewsQuery->whereNull('response');
        }

        // Search functionality
        if ($search) {
            $reviewsQuery->where(function ($query) use ($search) {
                $query->where('comment', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%");
                    })
                    ->orWhereHas('service', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Get reviews with pagination
        $reviews = $reviewsQuery->paginate(10);

        // Calculate statistics
        $stats = [
            'total' => Review::where('artisan_profile_id', $user->artisanProfile->id)->count(),
            'average_rating' => Review::where('artisan_profile_id', $user->artisanProfile->id)->avg('rating') ?? 0,
            'five_stars' => Review::where('artisan_profile_id', $user->artisanProfile->id)->where('rating', 5)->count(),
            'four_stars' => Review::where('artisan_profile_id', $user->artisanProfile->id)->where('rating', 4)->count(),
            'three_stars' => Review::where('artisan_profile_id', $user->artisanProfile->id)->where('rating', 3)->count(),
            'two_stars' => Review::where('artisan_profile_id', $user->artisanProfile->id)->where('rating', 2)->count(),
            'one_star' => Review::where('artisan_profile_id', $user->artisanProfile->id)->where('rating', 1)->count(),
            'pending_response' => Review::where('artisan_profile_id', $user->artisanProfile->id)->whereNull('response')->count(),
        ];

        return view('artisan.reviews', compact('reviews', 'stats', 'filter', 'search'));
    }

    /**
     * Submit a response to a review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond(Request $request, $id)
    {
        try {
            // Get the artisan profile first to ensure it exists
            $artisanProfile = ArtisanProfile::where('user_id', Auth::id())->firstOrFail();

            $review = Review::where('id', $id)
                ->where('artisan_profile_id', $artisanProfile->id)
                ->firstOrFail();
                
            $request->validate([
                'response' => 'required|string|max:1000',
            ]);

            $review->update([
                'response' => $request->response,
                'response_date' => now(),
            ]);

            Log::info('Review response submitted successfully', [
                'review_id' => $id,
                'artisan_id' => $artisanProfile->id,
                'user_id' => Auth::id()
            ]);

            return back()->with('success', 'Your response has been submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Error responding to review: ' . $e->getMessage(), [
                'review_id' => $id,
                'user_id' => Auth::id()
            ]);
            return back()->with('error', 'Unable to respond to the review. Please try again or contact support.');
        }
    }

    /**
     * Report a review as inappropriate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function report(Request $request, $id)
    {
        try {
            // Get the artisan profile first to ensure it exists
            $artisanProfile = ArtisanProfile::where('user_id', Auth::id())->firstOrFail();

            $review = Review::where('id', $id)
                ->where('artisan_profile_id', $artisanProfile->id)
                ->firstOrFail();

            $request->validate([
                'reason' => 'required|string|max:500',
            ]);

            $review->update([
                'reported' => true,
                'report_reason' => $request->reason,
                'report_date' => now(),
            ]);

            Log::info('Review reported successfully', [
                'review_id' => $id,
                'artisan_id' => $artisanProfile->id,
                'user_id' => Auth::id()
            ]);

            return back()->with('success', 'The review has been reported and will be reviewed by our team.');
        } catch (\Exception $e) {
            Log::error('Error reporting review: ' . $e->getMessage(), [
                'review_id' => $id,
                'user_id' => Auth::id()
            ]);
            return back()->with('error', 'Unable to report the review. Please try again or contact support.');
        }
    }
}
