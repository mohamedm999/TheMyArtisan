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
}