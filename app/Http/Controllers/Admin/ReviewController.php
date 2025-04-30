<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reviews = Review::with(['client', 'artisanProfile'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
        $review = Review::with(['client', 'artisanProfile'])->findOrFail($id);

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

        $review = Review::findOrFail($id);
        $review->status = $request->status;
        $review->save();

        return redirect()->route('admin.reviews.show', $id)
            ->with('success', 'Review status updated successfully.');
    }
}
