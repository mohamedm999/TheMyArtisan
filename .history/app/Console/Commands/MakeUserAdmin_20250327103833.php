<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'Make a user an admin by email';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        // Set the role column directly
        $user->role = 'admin';
        $user->save();

        // Also establish the role relationship
        try {
            // Get or create the admin role
            $adminRole = Role::firstOrCreate(['name' => 'admin'], ['display_name' => 'Administrator']);

            // Attach the role to the user if not already attached
            if (!$user->hasRole($adminRole)) {
                $user->roles()->attach($adminRole);
            }

            $this->info("User {$email} is now an admin!");
            return 0;
        } catch (\Exception $e) {
            $this->warn("User {$email} has been set as admin via the 'role' attribute, but there was an issue with the role relationship: " . $e->getMessage());
            return 0;
        }
    }
}
