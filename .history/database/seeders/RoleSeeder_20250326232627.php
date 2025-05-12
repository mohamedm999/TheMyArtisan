<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Platform administrator with full access'
            ],
            [
                'name' => 'artisan',
                'display_name' => 'Artisan',
                'description' => 'Artisan who provides services'
            ],
            [
                'name' => 'client',
                'display_name' => 'Client',
                'description' => 'Client who seeks services'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
