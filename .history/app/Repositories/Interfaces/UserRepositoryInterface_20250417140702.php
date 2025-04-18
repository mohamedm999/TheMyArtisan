<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    /**
     * Get a user by credentials
     *
     * @param array $credentials
     * @return User|null
     */
    public function findByCredentials(array $credentials);
    
    /**
     * Attempt user login
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function attemptLogin(array $credentials, bool $remember = false);
    
    /**
     * Get the currently authenticated user
     *
     * @return User|null
     */
    public function getAuthenticatedUser();
    
    /**
     * Logout the current user
     *
     * @return void
     */
    public function logout();
    
    /**
     * Find a user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id);
}