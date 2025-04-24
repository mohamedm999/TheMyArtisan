<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * Get filtered and paginated reviews for an artisan profile
     *
     * @param int $artisanProfileId
     * @param string|null $filter
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getFilteredReviews(int $artisanProfileId, ?string $filter = null, ?string $search = null): LengthAwarePaginator
    {
        $query = Review::where('artisan_profile_id', $artisanProfileId)
            ->with(['client', 'service', 'booking'])
            ->orderBy('created_at', 'desc');

        // Filter reviews
        if ($filter === 'positive') {
            $query->where('rating', '>=', 4);
        } elseif ($filter === 'neutral') {
            $query->whereBetween('rating', [3, 3.9]);
        } elseif ($filter === 'negative') {
            $query->where('rating', '<', 3);
        } elseif ($filter === 'pending') {
            $query->whereNull('response');
        }

        // Search functionality
        if ($search) {
            $query->where(function ($query) use ($search) {
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

        return $query->paginate(10);
    }

    /**
     * Get review statistics for an artisan profile
     *
     * @param int $artisanProfileId
     * @return array
     */
    public function getReviewStatistics(int $artisanProfileId): array
    {
        return [
            'total' => Review::where('artisan_profile_id', $artisanProfileId)->count(),
            'average_rating' => Review::where('artisan_profile_id', $artisanProfileId)->avg('rating') ?? 0,
            'five_stars' => Review::where('artisan_profile_id', $artisanProfileId)->where('rating', 5)->count(),
            'four_stars' => Review::where('artisan_profile_id', $artisanProfileId)->where('rating', 4)->count(),
            'three_stars' => Review::where('artisan_profile_id', $artisanProfileId)->where('rating', 3)->count(),
            'two_stars' => Review::where('artisan_profile_id', $artisanProfileId)->where('rating', 2)->count(),
            'one_star' => Review::where('artisan_profile_id', $artisanProfileId)->where('rating', 1)->count(),
            'pending_response' => Review::where('artisan_profile_id', $artisanProfileId)->whereNull('response')->count(),
        ];
    }

    /**
     * Get a specific review by ID and artisan profile ID
     *
     * @param int $reviewId
     * @param int $artisanProfileId
     * @return Review|null
     */
    public function getReviewByIdForArtisan(int $reviewId, int $artisanProfileId): ?Review
    {
        return Review::where('id', $reviewId)
            ->where('artisan_profile_id', $artisanProfileId)
            ->first();
    }

    /**
     * Submit a response to a review
     *
     * @param Review $review
     * @param string $response
     * @return bool
     */
    public function respondToReview(Review $review, string $response): bool
    {
        try {
            return $review->update([
                'response' => $response,
                'response_date' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error responding to review: ' . $e->getMessage(), [
                'review_id' => $review->id
            ]);
            return false;
        }
    }

    /**
     * Report a review as inappropriate
     *
     * @param Review $review
     * @param string $reason
     * @return bool
     */
    public function reportReview(Review $review, string $reason): bool
    {
        try {
            return $review->update([
                'reported' => true,
                'report_reason' => $reason,
                'report_date' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error reporting review: ' . $e->getMessage(), [
                'review_id' => $review->id
            ]);
            return false;
        }
    }
}