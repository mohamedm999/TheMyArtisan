<?php

namespace App\Factories;

use App\Models\User;
use App\Models\ClientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientFactory implements UserFactory
{
    /**
     * Create a client user based on the given request data
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

        // Assign client role
        $user->assignRole('client');
        
        // Create client profile
        ClientProfile::create([
            'user_id' => $user->id,
        ]);
        
        return $user;
    }
    
    /**
     * Handle post-registration redirect for client users
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterRegistration(User $user)
    {
        return redirect()->route('client.dashboard')
            ->with('success', 'Welcome! You can now browse and book artisan services.');
    }
}