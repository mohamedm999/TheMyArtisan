<?php

namespace App\Repositories\Interfaces;

use App\Models\ClientPoint;
use App\Models\User;
use App\Models\PointTransaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClientPointsRepositoryInterface
{
    /**
     * Get all clients with points data, paginated
     * 
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllClientPointsPaginated(array $filters = []): LengthAwarePaginator;

    /**
     * Get client point details by user ID
     * 
     * @param int $userId
     * @return ClientPoint|null
     */
    public function getClientPointsByUserId(int $userId): ?ClientPoint;

    /**
     * Get point transactions for a user, paginated
     * 
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPointTransactionsByUserId(int $userId, int $perPage = 10): LengthAwarePaginator;

    /**
     * Add or deduct points from a user's account
     * 
     * @param User $user
     * @param int $points
     * @param string $reason
     * @param int $adminId
     * @return bool
     */
    public function adjustPoints(User $user, int $points, string $reason, int $adminId): bool;

    /**
     * Get point transactions analytics
     * 
     * @return array
     */
    public function getPointsAnalytics(): array;

    /**
     * Create point transaction
     * 
     * @param array $data
     * @return PointTransaction
     */
    public function createPointTransaction(array $data): PointTransaction;

    /**
     * Get overall statistics for clients' points
     * 
     * @return array
     */
    public function getPointsStatistics(): array;
}
