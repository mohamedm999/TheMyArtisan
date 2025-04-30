<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\ArtisanProfile;
use App\Models\ClientProfile;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function findByCredentials(array $credentials)
    {
        return User::where('email', $credentials['email'])->first();
    }


    public function attemptLogin(array $credentials, bool $remember = false)
    {
        return Auth::attempt($credentials, $remember);
    }


    public function getAuthenticatedUser()
    {
        return Auth::user();
    }


    public function logout()
    {
        Auth::logout();
    }

    public function findById(int $id)
    {
        return User::find($id);
    }

    /**
     * Create a new user with the given data
     *
     * @param array $userData
     * @return User
     */
    public function create(array $userData): User
    {
        return User::create([
            'firstname' => $userData['firstname'],
            'lastname' => $userData['lastname'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);
    }

    /**
     * Assign a role to a user
     *
     * @param User $user
     * @param string $role
     * @return User
     */
    public function assignRole(User $user, string $role): User
    {
        $user->assignRole($role);
        return $user;
    }

    /**
     * Setup user profile based on role
     *
     * @param User $user
     * @param string $role
     * @param array $profileData
     * @return User
     */
    public function setupUserProfile(User $user, string $role, array $profileData = []): User
    {
        if ($role === 'artisan') {
            ArtisanProfile::create([
                'user_id' => $user->id,
                'bio' => $profileData['bio'] ?? null,
                'status' => 'pending', // New artisans start as pending
            ]);
        } elseif ($role === 'client') {
            ClientProfile::create([
                'user_id' => $user->id,
            ]);
        }

        return $user->fresh();
    }
}
