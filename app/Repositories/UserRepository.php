<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get a user by credentials
     *
     * @param array $credentials
     * @return User|null
     */
    public function findByCredentials(array $credentials)
    {
        return User::where('email', $credentials['email'])->first();
    }
    
    /**
     * Attempt user login
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function attemptLogin(array $credentials, bool $remember = false)
    {
        return Auth::attempt($credentials, $remember);
    }
    
    /**
     * Get the currently authenticated user
     *
     * @return User|null
     */
    public function getAuthenticatedUser()
    {
        return Auth::user();
    }
    
    /**
     * Logout the current user
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
    }
    
    /**
     * Find a user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id)
    {
        return User::find($id);
    }
}