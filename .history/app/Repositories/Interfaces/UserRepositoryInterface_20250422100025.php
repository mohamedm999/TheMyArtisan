<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function findByCredentials(array $credentials);
    
    public function attemptLogin(array $credentials, bool $remember = false);
    
    public function getAuthenticatedUser();
    
    public function logout();
    
    public function findById(int $id);
    
    /**
     * Create a new user with the given data
     *
     * @param array $userData
     * @return User
     */
    public function create(array $userData): User;
    
    /**
     * Assign a role to a user
     *
     * @param User $user
     * @param string $role
     * @return User
     */
    public function assignRole(User $user, string $role): User;
    
    /**
     * Setup user profile based on role
     *
     * @param User $user
     * @param string $role
     * @param array $profileData
     * @return User
     */
    public function setupUserProfile(User $user, string $role, array $profileData = []): User;
}