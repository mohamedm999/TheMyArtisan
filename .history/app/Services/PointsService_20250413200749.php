<?php

namespace App\Services;

use App\Models\User;
use App\Models\ClientPoint;
use App\Models\PointTransaction;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class PointsService
{
    /**
     * Award points to a client for completing a booking.
     *
     * @param Booking $booking
     * @return void
     */
    public function awardBookingPoints(Booking $booking)
    {
        // Only award points if booking is completed
        if ($booking->status !== 'completed') {
            return;
        }
        
        $client = $booking->client;
        
        // Make sure client exists and is still a client
        if (!$client || !$client->hasRole('client')) {
            return;
        }

        // Calculate points (e.g., 10% of booking price as points)
        $pointsToAward = $this->calculateBookingPoints($booking);
        
        if ($pointsToAward <= 0) {
            return;
        }
        
        // Award the points (in a transaction to ensure all operations succeed together)
        $this->addPoints($client, $pointsToAward, "Points earned from booking #{$booking->id}", $booking);
    }

    /**
     * Calculate how many points to award for a booking.
     *
     * @param Booking $booking
     * @return int
     */
    protected function calculateBookingPoints(Booking $booking)
    {
        // Default strategy: 1 point per $1 spent
        if (empty($booking->price) || $booking->price <= 0) {
            return 0;
        }
        
        // Round down to nearest integer
        return (int) floor($booking->price);
    }

    /**
     * Award points to a client for registering on the platform.
     *
     * @param User $user
     * @return void
     */
    public function awardWelcomePoints(User $user)
    {
        // Check if user is a client
        if (!$user->hasRole('client')) {
            return;
        }
        
        // Default welcome bonus: 100 points
        $welcomePoints = 100;
        
        // Add the points
        $this->addPoints($user, $welcomePoints, "Welcome bonus for joining MyArtisan!", $user);
    }
    
    /**
     * Award points to a client for reviewing an artisan.
     *
     * @param User $user
     * @param int $reviewId
     * @return void
     */
    public function awardReviewPoints(User $user, $reviewId)
    {
        // Check if user is a client
        if (!$user->hasRole('client')) {
            return;
        }
        
        // Default review points: 25 points
        $reviewPoints = 25;
        
        // Add the points
        $this->addPoints(
            $user,
            $reviewPoints,
            "Points earned for leaving a review",
            null,
            [
                'transactionable_type' => 'App\\Models\\Review',
                'transactionable_id' => $reviewId
            ]
        );
    }
    
    /**
     * Add points to a user's account.
     *
     * @param User $user
     * @param int $points
     * @param string $description
     * @param mixed|null $transactionable
     * @param array|null $transactionableOverride
     * @return bool
     */
    public function addPoints(User $user, int $points, string $description, $transactionable = null, ?array $transactionableOverride = null)
    {
        if ($points <= 0) {
            return false;
        }
        
        // Start a database transaction to ensure all operations succeed together
        return DB::transaction(function() use ($user, $points, $description, $transactionable, $transactionableOverride) {
            // Get or create client points record
            $clientPoints = ClientPoint::firstOrCreate(
                ['user_id' => $user->id],
                ['points_balance' => 0, 'lifetime_points' => 0]
            );
            
            // Update points balance
            $clientPoints->points_balance += $points;
            $clientPoints->lifetime_points += $points;
            $clientPoints->save();
            
            // Prepare transaction data
            $transactionData = [
                'user_id' => $user->id,
                'points' => $points,
                'type' => PointTransaction::TYPE_EARNED,
                'description' => $description,
            ];
            
            // Set transactionable if provided
            if ($transactionableOverride) {
                $transactionData['transactionable_type'] = $transactionableOverride['transactionable_type'];
                $transactionData['transactionable_id'] = $transactionableOverride['transactionable_id'];
            } elseif ($transactionable) {
                $transactionData['transactionable_type'] = get_class($transactionable);
                $transactionData['transactionable_id'] = $transactionable->id;
            }
            
            // Create transaction record
            PointTransaction::create($transactionData);
            
            return true;
        });
    }
    
    /**
     * Deduct points from a user's account.
     *
     * @param User $user
     * @param int $points
     * @param string $description
     * @param mixed|null $transactionable
     * @return bool
     */
    public function deductPoints(User $user, int $points, string $description, $transactionable = null)
    {
        if ($points <= 0) {
            return false;
        }
        
        // Ensure we have a positive value to deduct
        $pointsToDeduct = abs($points);
        
        // Start a database transaction to ensure all operations succeed together
        return DB::transaction(function() use ($user, $pointsToDeduct, $description, $transactionable) {
            // Get client points record
            $clientPoints = $user->points;
            
            // Check if client has points record and enough balance
            if (!$clientPoints || $clientPoints->points_balance < $pointsToDeduct) {
                return false;
            }
            
            // Update points balance
            $clientPoints->points_balance -= $pointsToDeduct;
            $clientPoints->save();
            
            // Prepare transaction data
            $transactionData = [
                'user_id' => $user->id,
                'points' => -$pointsToDeduct, // Negative for deduction
                'type' => PointTransaction::TYPE_SPENT,
                'description' => $description,
            ];
            
            // Set transactionable if provided
            if ($transactionable) {
                $transactionData['transactionable_type'] = get_class($transactionable);
                $transactionData['transactionable_id'] = $transactionable->id;
            }
            
            // Create transaction record
            PointTransaction::create($transactionData);
            
            return true;
        });
    }
}