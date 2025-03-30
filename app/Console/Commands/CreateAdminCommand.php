<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
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
            $user = User::create([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin', // Changed from is_admin to role
                'status' => User::STATUS_ACTIVE, // Add status for good measure
            ]);

            // Also create the role relationship if your app uses it
            try {
                if (class_exists('App\Models\Role')) {
                    $adminRole = \App\Models\Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrator']);
                    $user->roles()->attach($adminRole);
                }
            } catch (\Exception $e) {
                $this->warn("Role relationship could not be established: " . $e->getMessage());
                $this->info("But the user was created with role='admin' in the users table.");
            }

            $this->info("Admin user {$firstname} {$lastname} created successfully!");
            $this->line("Email: {$email}");
            $this->line("Password: " . ($this->argument('password') ? "As provided" : $password . " (default)"));

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to create admin user: ' . $e->getMessage());
            return 1;
        }
    }
}
