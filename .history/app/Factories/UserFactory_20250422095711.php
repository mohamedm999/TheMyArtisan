<?php

namespace App\Factories;

use App\Models\User;
use Illuminate\Http\Request;

interface UserFactory
{
    /**
     * Create a user based on the given request data
     *
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request): User;
    
    /**
     * Handle post-registration redirect for the user
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterRegistration(User $user);
}