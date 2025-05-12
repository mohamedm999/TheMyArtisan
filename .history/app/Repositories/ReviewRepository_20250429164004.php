<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

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

    /**
     * Get all reviews with relationships for admin
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllReviewsForAdmin(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = Review::with(['client.user', 'artisanProfile.user', 'service']);

        // Filter by status if provided
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by rating if provided
        if (!empty($filters['rating'])) {
            $query->where('rating', $filters['rating']);
        }

        // Filter by reported reviews
        if (!empty($filters['reported']) && $filters['reported'] === 'true') {
            $query->where('reported', true);
        }

        // Filter by search term
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', '%' . $search . '%')
                  ->orWhere('response', 'like', '%' . $search . '%')
                  ->orWhereHas('artisanProfile.user', function($sq) use ($search) {
                      $sq->where('firstname', 'like', '%' . $search . '%')
                        ->orWhere('lastname', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('client.user', function($sq) use ($search) {
                      $sq->where('firstname', 'like', '%' . $search . '%')
                        ->orWhere('lastname', 'like', '%' . $search . '%');
                  });
            });
        }

        // Sort by field
        $sortBy = !empty($filters['sort_by']) ? $filters['sort_by'] : 'created_at';
        $sortDirection = !empty($filters['sort_direction']) ? $filters['sort_direction'] : 'desc';
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate($perPage);
    }

    /**
     * Get review statistics for admin dashboard
     *
     * @return array
     */
    public function getReviewStatisticsForAdmin(): array
    {
        return [
            'total' => Review::count(),
            'average_rating' => Review::avg('rating') ?? 0,
            'reported' => Review::where('reported', true)->count(),
            'hidden' => Review::where('status', 'hidden')->count(),
            'this_month' => Review::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'rating_distribution' => [
                '5' => Review::where('rating', 5)->count(),
                '4' => Review::where('rating', 4)->count(),
                '3' => Review::where('rating', 3)->count(),
                '2' => Review::where('rating', 2)->count(),
                '1' => Review::where('rating', 1)->count(),
            ],
        ];
    }

    /**
     * Bulk update review statuses
     *
     * @param array $reviewIds
     * @param string $status
     * @return int Number of reviews updated
     */
    public function bulkUpdateReviewStatus(array $reviewIds, string $status): int
    {
        try {
            $count = Review::whereIn('id', $reviewIds)
                ->update([
                    'status' => $status,
                    'admin_notes' => \DB::raw("CONCAT(IFNULL(admin_notes, ''), '\nBulk status update to \"" . $status . "\" on " . now()->format('Y-m-d H:i:s') . "')")
                ]);

            return $count;
        } catch (\Exception $e) {
            Log::error('Error bulk updating review statuses: ' . $e->getMessage(), [
                'review_ids' => $reviewIds,
                'status' => $status
            ]);
            return 0;
        }
    }

    /**
     * Add admin note to a review
     *
     * @param int $reviewId
     * @param string $note
     * @return bool
     */
    public function addAdminNote(int $reviewId, string $note): bool
    {
        try {
            $review = Review::findOrFail($reviewId);
            $timestamp = now()->format('Y-m-d H:i:s');

            $review->admin_notes = $review->admin_notes
                ? $review->admin_notes . "\n[{$timestamp}] {$note}"
                : "[{$timestamp}] {$note}";

            return $review->save();
        } catch (\Exception $e) {
            Log::error('Error adding admin note to review: ' . $e->getMessage(), [
                'review_id' => $reviewId
            ]);
            return false;
        }
    }
}
