<?php

namespace App\Factories;

use Exception;

class UserFactoryCreator
{
    /**
     * Get the appropriate user factory based on role
     *
     * @param string $role
     * @return UserFactory
     * @throws Exception
     */
    public static function getFactory(string $role): UserFactory
    {
        switch ($role) {
            case 'artisan':
                return new ArtisanFactory();
            case 'client':
                return new ClientFactory();
            default:
                throw new Exception("Unsupported user role: {$role}");
        }
    }
}