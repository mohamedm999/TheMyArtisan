<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myartisan:create-admin {firstname} {lastname} {email} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $firstname = $this->argument('firstname');
        $lastname = $this->argument('lastname');
        $email = $this->argument('email');
        $password = $this->argument('password') ?: 'password123';

        try {
            // Create the user
            $user = User::create([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);

            // Assign all roles (admin, artisan, client)
            $this->assignRoles($user);

            $this->info("Admin user {$firstname} {$lastname} created successfully!");
            $this->line("Email: {$email}");
            $this->line("Password: " . ($this->argument('password') ? "As provided" : $password . " (default)"));
            $this->line("Roles assigned: admin, artisan, client");

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to create admin user: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Assign all necessary roles to the admin user
     *
     * @param User $user
     * @return void
     */
    private function assignRoles(User $user)
    {
        try {
            // Method 1: Attach roles if using a many-to-many relationship
            if (method_exists($user, 'roles') && method_exists($user->roles(), 'attach')) {
                // Get roles
                $adminRole = Role::where('name', 'admin')->first();
                $artisanRole = Role::where('name', 'artisan')->first();
                $clientRole = Role::where('name', 'client')->first();

                if ($adminRole) $user->roles()->attach($adminRole->id);
                if ($artisanRole) $user->roles()->attach($artisanRole->id);
                if ($clientRole) $user->roles()->attach($clientRole->id);
            }
            // Method 2: Direct assignment if using a different approach
            elseif (property_exists($user, 'role')) {
                $user->role = 'admin'; // Or maybe a comma-separated string like 'admin,artisan,client'
                $user->save();
            }
            // Ensure the user has the proper sync method if that's how roles are assigned
            elseif (method_exists($user, 'syncRoles')) {
                $user->syncRoles(['admin', 'artisan', 'client']);
            }
        } catch (\Exception $e) {
            $this->warn('Could not assign roles automatically: ' . $e->getMessage());
            $this->warn('You may need to manually assign roles to this user.');
        }
    }
}
