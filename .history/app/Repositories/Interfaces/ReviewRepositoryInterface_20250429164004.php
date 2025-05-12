<?php

namespace App\Repositories\Interfaces;

use App\Models\Review;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ReviewRepositoryInterface
{
    /**
     * Get filtered and paginated reviews for an artisan profile
     *
     * @param int $artisanProfileId
     * @param string|null $filter
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getFilteredReviews(int $artisanProfileId, ?string $filter = null, ?string $search = null): LengthAwarePaginator;

    /**
     * Get review statistics for an artisan profile
     *
     * @param int $artisanProfileId
     * @return array
     */
    public function getReviewStatistics(int $artisanProfileId): array;

    /**
     * Get a specific review by ID and artisan profile ID
     *
     * @param int $reviewId
     * @param int $artisanProfileId
     * @return Review|null
     */
    public function getReviewByIdForArtisan(int $reviewId, int $artisanProfileId): ?Review;

    /**
     * Submit a response to a review
     *
     * @param Review $review
     * @param string $response
     * @return bool
     */
    public function respondToReview(Review $review, string $response): bool;

    /**
     * Report a review as inappropriate
     *
     * @param Review $review
     * @param string $reason
     * @return bool
     */
    public function reportReview(Review $review, string $reason): bool;

    /**
     * Get all reviews with relationships for admin
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllReviewsForAdmin(int $perPage = 10, array $filters = []): LengthAwarePaginator;

    /**
     * Get review statistics for admin dashboard
     *
     * @return array
     */
    public function getReviewStatisticsForAdmin(): array;

    /**
     * Bulk update review statuses
     *
     * @param array $reviewIds
     * @param string $status
     * @return int Number of reviews updated
     */
    public function bulkUpdateReviewStatus(array $reviewIds, string $status): int;

    /**
     * Add admin note to a review
     *
     * @param int $reviewId
     * @param string $note
     * @return bool
     */
    public function addAdminNote(int $reviewId, string $note): bool;
}
