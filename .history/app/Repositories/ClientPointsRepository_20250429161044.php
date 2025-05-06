<?php

namespace App\Repositories;

use App\Models\ClientPoint;
use App\Models\User;
use App\Models\PointTransaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Repositories\Interfaces\ClientPointsRepositoryInterface;

class ClientPointsRepository implements ClientPointsRepositoryInterface
{
    /**
     * Get all clients with points data, paginated
     * 
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllClientPointsPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = User::select('users.*')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->leftJoin('client_points', 'users.id', '=', 'client_points.user_id')
            ->where('roles.name', '=', 'client');

        // Apply search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('users.firstname', 'like', "%{$search}%")
                  ->orWhere('users.lastname', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        // Apply sort
        $sortField = $filters['sort_field'] ?? 'users.created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        $perPage = $filters['per_page'] ?? 10;
        
        return $query->with('points')->paginate($perPage);
    }

    /**
     * Get client point details by user ID
     *
     * @param int $userId
     * @return ClientPoint|null
     */
    public function getClientPointsByUserId(int $userId): ?ClientPoint
    {
        return ClientPoint::where('user_id', $userId)->first();
    }

    /**
     * Get point transactions for a user, paginated
     *
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPointTransactionsByUserId(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return PointTransaction::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Add or deduct points from a user's account
     *
     * @param User $user
     * @param int $points
     * @param string $reason
     * @param int $adminId
     * @return bool
     */
    public function adjustPoints(User $user, int $points, string $reason, int $adminId): bool
    {
        // Start transaction for consistency
        DB::beginTransaction();

        try {
            // Get or create client points record
            $clientPoints = ClientPoint::firstOrCreate(
                ['user_id' => $user->id],
                ['points_balance' => 0, 'lifetime_points' => 0]
            );

            // Determine transaction type
            $type = $points > 0 ? 'earned' : 'adjusted';

            // Update points balance
            $clientPoints->points_balance += $points;

            // If adding points, also update lifetime points
            if ($points > 0) {
                $clientPoints->lifetime_points += $points;
            }

            $clientPoints->save();

            // Create transaction record
            $this->createPointTransaction([
                'user_id' => $user->id,
                'points' => $points,
                'type' => $type,
                'description' => $reason,
                'transactionable_type' => User::class,
                'transactionable_id' => $adminId
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adjusting points: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'points' => $points,
                'admin_id' => $adminId
            ]);
            return false;
        }
    }

    /**
     * Create point transaction
     *
     * @param array $data
     * @return PointTransaction
     */
    public function createPointTransaction(array $data): PointTransaction
    {
        return PointTransaction::create($data);
    }

    /**
     * Get point transactions analytics
     *
     * @return array
     */
    public function getPointsAnalytics(): array
    {
        // Points awarded today
        $today = PointTransaction::where('type', 'earned')
            ->whereDate('created_at', Carbon::today())
            ->sum('points');

        // Points awarded this week
        $thisWeek = PointTransaction::where('type', 'earned')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('points');

        // Points awarded this month
        $thisMonth = PointTransaction::where('type', 'earned')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('points');

        // Total points ever awarded
        $totalAwarded = PointTransaction::where('type', 'earned')
            ->sum('points');

        // Points redeemed today
        $todayRedeemed = PointTransaction::where('type', 'redeemed')
            ->whereDate('created_at', Carbon::today())
            ->sum('points');

        // Points redeemed this month
        $monthRedeemed = PointTransaction::where('type', 'redeemed')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('points');

        // Total points redeemed
        $totalRedeemed = PointTransaction::where('type', 'redeemed')
            ->sum('points');

        // Points by source
        $pointsBySource = PointTransaction::where('type', 'earned')
            ->select('transactionable_type', DB::raw('SUM(points) as total_points'))
            ->groupBy('transactionable_type')
            ->get()
            ->mapWithKeys(function ($item) {
                $key = class_basename($item->transactionable_type);
                return [$key => $item->total_points];
            })
            ->toArray();

        // Top 5 clients by lifetime points
        $topClients = ClientPoint::orderBy('lifetime_points', 'desc')
            ->with('user:id,firstname,lastname,email')
            ->limit(5)
            ->get()
            ->map(function ($clientPoint) {
                return [
                    'user_id' => $clientPoint->user_id,
                    'name' => $clientPoint->user->firstname . ' ' . $clientPoint->user->lastname,
                    'email' => $clientPoint->user->email,
                    'lifetime_points' => $clientPoint->lifetime_points,
                    'current_balance' => $clientPoint->points_balance,
                ];
            })
            ->toArray();

        return [
            'points_awarded' => [
                'today' => $today,
                'this_week' => $thisWeek,
                'this_month' => $thisMonth,
                'all_time' => $totalAwarded,
            ],
            'points_redeemed' => [
                'today' => $todayRedeemed,
                'this_month' => $monthRedeemed,
                'all_time' => $totalRedeemed,
            ],
            'points_by_source' => $pointsBySource,
            'top_clients' => $topClients,
        ];
    }

    /**
     * Get overall statistics for clients' points
     *
     * @return array
     */
    public function getPointsStatistics(): array
    {
        // Total clients with points
        $totalClientsWithPoints = ClientPoint::count();

        // Total points in circulation
        $totalPointsInCirculation = ClientPoint::sum('points_balance');

        // Total lifetime points
        $totalLifetimePoints = ClientPoint::sum('lifetime_points');

        // Average points per client
        $averagePointsPerClient = $totalClientsWithPoints > 0
            ? $totalPointsInCirculation / $totalClientsWithPoints
            : 0;

        // Number of transactions in the last 30 days
        $transactionsLast30Days = PointTransaction::where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        return [
            'total_clients_with_points' => $totalClientsWithPoints,
            'total_points_in_circulation' => $totalPointsInCirculation,
            'total_lifetime_points' => $totalLifetimePoints,
            'average_points_per_client' => round($averagePointsPerClient, 2),
            'transactions_last_30_days' => $transactionsLast30Days,
        ];
    }
}
