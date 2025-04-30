<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ArtisanProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    /**
     * Respond to a review
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function respond(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string|min:10|max:1000',
        ]);

        try {
            // Get current artisan profile
            $artisanProfile = ArtisanProfile::where('user_id', Auth::id())->firstOrFail();

            // Find the review that belongs to this artisan
            $review = Review::where('id', $id)
                ->where('artisan_profile_id', $artisanProfile->id)
                ->firstOrFail();

            // Update the review with the response
            $review->response = $request->response;
            $review->response_date = Carbon::now();
            $review->save();

            return redirect()->route('artisan.reviews')
                ->with('success', 'Your response has been successfully added to the review.');

        } catch (\Exception $e) {
            return back()->with('error', 'Unable to respond to this review: ' . $e->getMessage());
        }
    }

    /**
     * Report a review
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function report(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10|max:1000',
        ]);

        try {
            // Get current artisan profile
            $artisanProfile = ArtisanProfile::where('user_id', Auth::id())->firstOrFail();

            // Find the review that belongs to this artisan
            $review = Review::where('id', $id)
                ->where('artisan_profile_id', $artisanProfile->id)
                ->firstOrFail();

            // Update the review with the report information
            $review->reported = true;
            $review->report_reason = $request->reason;
            $review->report_date = Carbon::now();
            $review->save();

            return redirect()->route('artisan.reviews')
                ->with('success', 'This review has been reported to our administrators for review.');

        } catch (\Exception $e) {
            return back()->with('error', 'Unable to report this review: ' . $e->getMessage());
        }
    }
}
