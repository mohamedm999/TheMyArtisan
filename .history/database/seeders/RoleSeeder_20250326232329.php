<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Make sure we have all required roles
        $roles = ['admin', 'artisan', 'client'];

        foreach ($roles as $roleName) {
            Role::updateOrCreate(
                ['name' => $roleName],
                ['name' => $roleName, 'description' => ucfirst($roleName) . ' role']
            );
        }

        $this->command->info('Roles seeded/updated successfully!');
    }
}
