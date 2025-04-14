<?php

namespace App\Observers;

use App\Models\User;
use App\Services\PointsService;

class UserObserver
{
    /**
     * The points service instance.
     *
     * @var PointsService
     */
    protected $pointsService;

    /**
     * Create a new observer instance.
     *
     * @param  PointsService  $pointsService
     * @return void
     */
    public function __construct(PointsService $pointsService)
    {
        $this->pointsService = $pointsService;
    }

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // We'll check if the user is assigned a client role later
    }

    /**
     * Handle when a role is assigned to a user
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updatingRoles(User $user)
    {
        // Check if user is assigned the client role for the first time
        if ($user->hasRole('client')) {
            // Award welcome points to new clients
            $this->pointsService->awardWelcomePoints($user);
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
