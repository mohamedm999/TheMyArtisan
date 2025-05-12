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
     * @return LengthAwarePaginator
     */
    public function getAllReviewsForAdmin(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find a review by ID with relationships
     *
     * @param int $id
     * @return Review|null
     */
    public function findReviewWithRelationsForAdmin(int $id): ?Review;

    /**
     * Update review status
     *
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateReviewStatus(int $id, string $status): bool;
}
