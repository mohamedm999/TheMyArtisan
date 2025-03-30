<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing roles to avoid duplicates
        DB::table('roles')->truncate();
        
        // Create basic roles
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator with full access'],
            ['name' => 'artisan', 'description' => 'Artisan user'],
            ['name' => 'client', 'description' => 'Client user'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('Roles have been created!');
    }
}
