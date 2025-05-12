<?php

namespace App\Factories;

use App\Models\User;
use App\Models\ArtisanProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ArtisanFactory implements UserFactory
{
    /**
     * Create an artisan user based on the given request data
     *
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request): User
    {
        // Create base user
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign artisan role
        $user->assignRole('artisan');
        
        // Create artisan profile
        ArtisanProfile::create([
            'user_id' => $user->id,
            'bio' => $request->bio ?? null,
            'status' => 'pending', // New artisans start as pending
        ]);
        
        return $user;
    }
    
    /**
     * Handle post-registration redirect for artisan users
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterRegistration(User $user)
    {
        return redirect()->route('artisan.dashboard')
            ->with('success', 'Welcome! Please complete your artisan profile.');
    }
}