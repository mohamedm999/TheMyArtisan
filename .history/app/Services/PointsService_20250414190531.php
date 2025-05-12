<?php

namespace App\Services;

use App\Models\User;
use App\Models\Booking;
use App\Models\ClientPoint;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\DB;

class PointsService
{
    /**
     * Points awarded to clients for different actions
     */
    const WELCOME_POINTS = 100;
    const BOOKING_POINTS_MULTIPLIER = 0.05; // 5% of booking total value
    const MINIMUM_BOOKING_POINTS = 10;
    const REVIEW_POINTS = 25;

    /**
     * Get the current points balance for a user.
     *
     * @param int $userId
     * @return int
     */
    public function getUserPoints($userId)
    {
        $clientPoints = ClientPoint::where('user_id', $userId)->first();
        return $clientPoints ? $clientPoints->points_balance : 0;
    }

    /**
     * Award welcome points to a new client.
     *
     * @param User $user
     * @return bool
     */
    public function awardWelcomePoints(User $user)
    {
        if (!$user->hasRole('client')) {
            return false;
        }

        // Check if user already has a points record
        $points = $user->points;

        // Only award welcome points if this is the first time
        if ($points) {
            return false;
        }

        DB::beginTransaction();

        try {
            // Create points record with welcome points
            $clientPoints = ClientPoint::create([
                'user_id' => $user->id,
                'points_balance' => self::WELCOME_POINTS,
                'lifetime_points' => self::WELCOME_POINTS
            ]);

            // Record transaction
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => self::WELCOME_POINTS,
                'type' => PointTransaction::TYPE_EARNED,
                'description' => 'Welcome bonus points',
                'transactionable_type' => User::class,
                'transactionable_id' => $user->id
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error awarding welcome points: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Award points for completing a booking.
     *
     * @param Booking $booking
     * @return bool
     */
    public function awardBookingPoints(Booking $booking)
    {
        // Only award points if the booking has been completed
        if ($booking->status !== 'completed') {
            return false;
        }

        // Get the client user
        $user = $booking->user;
        if (!$user || !$user->hasRole('client')) {
            return false;
        }

        // Calculate points to award (5% of booking value or minimum)
        $points = max(
            round($booking->total_price * self::BOOKING_POINTS_MULTIPLIER),
            self::MINIMUM_BOOKING_POINTS
        );

        DB::beginTransaction();

        try {
            // Get or create client points record
            $clientPoints = ClientPoint::firstOrCreate(
                ['user_id' => $user->id],
                ['points_balance' => 0, 'lifetime_points' => 0]
            );

            // Update points
            $clientPoints->points_balance += $points;
            $clientPoints->lifetime_points += $points;
            $clientPoints->save();

            // Record transaction
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => $points,
                'type' => PointTransaction::TYPE_EARNED,
                'description' => "Points earned for booking #{$booking->id}",
                'transactionable_type' => Booking::class,
                'transactionable_id' => $booking->id
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error awarding booking points: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Award points for writing a review.
     *
     * @param User $user
     * @param int $reviewId
     * @return bool
     */
    public function awardReviewPoints(User $user, $reviewId)
    {
        if (!$user->hasRole('client')) {
            return false;
        }

        DB::beginTransaction();

        try {
            // Get or create client points record
            $clientPoints = ClientPoint::firstOrCreate(
                ['user_id' => $user->id],
                ['points_balance' => 0, 'lifetime_points' => 0]
            );

            // Update points
            $clientPoints->points_balance += self::REVIEW_POINTS;
            $clientPoints->lifetime_points += self::REVIEW_POINTS;
            $clientPoints->save();

            // Record transaction
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => self::REVIEW_POINTS,
                'type' => PointTransaction::TYPE_EARNED,
                'description' => "Points earned for writing review #{$reviewId}",
                'transactionable_type' => 'App\Models\Review',
                'transactionable_id' => $reviewId
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error awarding review points: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Award custom points to a client.
     *
     * @param User $user
     * @param int $points
     * @param string $reason
     * @param string $type
     * @return bool
     */
    public function awardCustomPoints(User $user, $points, $reason, $type = PointTransaction::TYPE_EARNED)
    {
        if (!$user->hasRole('client') || $points <= 0) {
            return false;
        }

        DB::beginTransaction();

        try {
            // Get or create client points record
            $clientPoints = ClientPoint::firstOrCreate(
                ['user_id' => $user->id],
                ['points_balance' => 0, 'lifetime_points' => 0]
            );

            // Update points
            $clientPoints->points_balance += $points;
            $clientPoints->lifetime_points += $points;
            $clientPoints->save();

            // Record transaction
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => $points,
                'type' => $type,
                'description' => $reason,
                'transactionable_type' => User::class,
                'transactionable_id' => $user->id
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error awarding custom points: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Deduct points from a client.
     *
     * @param User $user
     * @param int $points
     * @param string $reason
     * @param string $type
     * @return bool
     */
    public function deductPoints(User $user, $points, $reason, $type = PointTransaction::TYPE_SPENT)
    {
        if (!$user->hasRole('client') || $points <= 0) {
            return false;
        }

        DB::beginTransaction();

        try {
            // Get client points record
            $clientPoints = $user->points;

            // Check if client has enough points
            if (!$clientPoints || $clientPoints->points_balance < $points) {
                DB::rollBack();
                return false;
            }

            // Update points balance
            $clientPoints->points_balance -= $points;
            $clientPoints->save();

            // Record transaction
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => -$points, // Negative to indicate points were deducted
                'type' => $type,
                'description' => $reason,
                'transactionable_type' => User::class,
                'transactionable_id' => $user->id
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deducting points: ' . $e->getMessage());
            return false;
        }
    }
}
