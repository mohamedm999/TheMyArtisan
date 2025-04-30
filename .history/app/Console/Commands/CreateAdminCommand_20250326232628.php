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
                'is_admin' => true,
            ]);

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
