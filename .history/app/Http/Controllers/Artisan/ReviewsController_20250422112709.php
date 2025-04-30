<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\ReviewRepositoryInterface;

class ReviewsController extends Controller
{
    /**
     * The review repository implementation.
     *
     * @var ReviewRepositoryInterface
     */
    protected $reviewRepository;

    /**
     * Create a new controller instance.
     *
     * @param ReviewRepositoryInterface $reviewRepository
     * @return void
     */
    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Display a listing of reviews for the authenticated artisan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $artisanProfileId = $user->artisanProfile->id;

        $filter = $request->input('filter', 'all');
        $search = $request->input('search');

        // Get reviews using repository
        $reviews = $this->reviewRepository->getFilteredReviews($artisanProfileId, $filter, $search);

        // Get review statistics using repository
        $stats = $this->reviewRepository->getReviewStatistics($artisanProfileId);

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

            // Get the review using repository
            $review = $this->reviewRepository->getReviewByIdForArtisan($id, $artisanProfile->id);

            if (!$review) {
                return back()->with('error', 'Review not found or you do not have permission to respond to this review.');
            }

            $request->validate([
                'response' => 'required|string|max:1000',
            ]);

            // Submit the response using repository
            $success = $this->reviewRepository->respondToReview($review, $request->response);

            if ($success) {
                return back()->with('success', 'Your response has been submitted successfully.');
            } else {
                return back()->with('error', 'Unable to respond to the review. Please try again or contact support.');
            }
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

            // Get the review using repository
            $review = $this->reviewRepository->getReviewByIdForArtisan($id, $artisanProfile->id);

            if (!$review) {
                return back()->with('error', 'Review not found or you do not have permission to report this review.');
            }

            $request->validate([
                'reason' => 'required|string|max:500',
            ]);

            // Report the review using repository
            $success = $this->reviewRepository->reportReview($review, $request->reason);

            if ($success) {
                Log::info('Review reported successfully', [
                    'review_id' => $id,
                    'artisan_id' => $artisanProfile->id,
                    'user_id' => Auth::id()
                ]);
                return back()->with('success', 'The review has been reported and will be reviewed by our team.');
            } else {
                return back()->with('error', 'Unable to report the review. Please try again or contact support.');
            }
        } catch (\Exception $e) {
            Log::error('Error reporting review: ' . $e->getMessage(), [
                'review_id' => $id,
                'user_id' => Auth::id()
            ]);
            return back()->with('error', 'Unable to report the review. Please try again or contact support.');
        }
    }
}
