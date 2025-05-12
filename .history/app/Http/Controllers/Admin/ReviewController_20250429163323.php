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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reviews = $this->reviewRepository->getAllReviewsForAdmin(10);
        return view('admin.reviews.index', compact('reviews'));
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
}
