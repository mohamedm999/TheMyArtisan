<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * The review repository instance.
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
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Display a listing of the reviews.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = [
            'status' => $request->status,
            'rating' => $request->rating,
            'reported' => $request->reported,
            'search' => $request->search,
            'sort_by' => $request->sort_by,
            'sort_direction' => $request->sort_direction
        ];

        $reviews = $this->reviewRepository->getAllReviewsForAdmin(10, $filters);
        $stats = $this->reviewRepository->getReviewStatisticsForAdmin();
        
        return view('admin.reviews.index', compact('reviews', 'stats', 'filters'));
    }

    /**
     * Display the specified review.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $review = $this->reviewRepository->findReviewWithRelationsForAdmin($id);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Update the status of the review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:published,hidden,reported',
        ]);

        if ($this->reviewRepository->updateReviewStatus($id, $request->status)) {
            return redirect()->route('admin.reviews.show', $id)
                ->with('success', 'Review status updated successfully.');
        }

        return redirect()->route('admin.reviews.show', $id)
            ->with('error', 'Error updating review status. Please try again.');
    }

    /**
     * Bulk update the status of multiple reviews.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'required|integer|exists:reviews,id',
            'status' => 'required|in:published,hidden,reported',
        ]);

        $count = $this->reviewRepository->bulkUpdateReviewStatus($request->review_ids, $request->status);

        if ($count > 0) {
            return redirect()->route('admin.reviews.index')
                ->with('success', "{$count} reviews were updated successfully.");
        }

        return redirect()->route('admin.reviews.index')
            ->with('error', 'Error updating reviews. Please try again.');
    }

    /**
     * Add an admin note to a review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addNote(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        if ($this->reviewRepository->addAdminNote($id, $request->admin_note)) {
            return redirect()->route('admin.reviews.show', $id)
                ->with('success', 'Note added successfully.');
        }

        return redirect()->route('admin.reviews.show', $id)
            ->with('error', 'Error adding note. Please try again.');
    }

    /**
     * Get review statistics for admin dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats()
    {
        $stats = $this->reviewRepository->getReviewStatisticsForAdmin();
        return response()->json($stats);
    }
}
