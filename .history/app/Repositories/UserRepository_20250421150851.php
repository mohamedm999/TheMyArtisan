<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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
}