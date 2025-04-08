<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

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

        $reviewsQuery = Review::where('artisan_profile_id', $user->id)
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
            'total' => Review::where('artisan_profile_id', $user->id)->count(),
            'average_rating' => Review::where('artisan_profile_id', $user->id)->avg('rating') ?? 0,
            'five_stars' => Review::where('artisan_profile_id', $user->id)->where('rating', 5)->count(),
            'four_stars' => Review::where('artisan_profile_id', $user->id)->where('rating', 4)->count(),
            'three_stars' => Review::where('artisan_profile_id', $user->id)->where('rating', 3)->count(),
            'two_stars' => Review::where('artisan_profile_id', $user->id)->where('rating', 2)->count(),
            'one_star' => Review::where('artisan_profile_id', $user->id)->where('rating', 1)->count(),
            'pending_response' => Review::where('artisan_profile_id', $user->id)->whereNull('response')->count(),
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
        $review = Review::where('id', $id)
            ->where('artisan_profile_id', Auth::user()->artisanProfile->id)
            ->firstOrFail();

        $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        $review->update([
            'response' => $request->response,
            'response_date' => now(),
        ]);

        return back()->with('success', 'Your response has been submitted.');
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
        $review = Review::where('id', $id)
            ->where('artisan_profile_id', Auth::user()->artisanProfile->id)
            ->firstOrFail();

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $review->update([
            'reported' => true,
            'report_reason' => $request->reason,
            'report_date' => now(),
        ]);

        return back()->with('success', 'The review has been reported and will be reviewed by our team.');
    }
}
