<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArtisanProfile;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class ArtisanProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create categories if they don't exist
        $categories = [
            ['name' => 'Woodworking', 'description' => 'Craftspeople who work with wood'],
            ['name' => 'Ceramics', 'description' => 'Pottery and ceramic arts'],
            ['name' => 'Jewelry Making', 'description' => 'Creating handmade jewelry'],
            ['name' => 'Textiles', 'description' => 'Working with fabrics and fibers'],
            ['name' => 'Metalwork', 'description' => 'Blacksmiths and metal artists']
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }

        // Get category IDs
        $categoryIds = Category::pluck('id')->toArray();

        // Sample cities
        $cities = ['Lagos', 'Abuja', 'Port Harcourt', 'Ibadan', 'Kano', 'Enugu', 'Asaba', 'Calabar'];

        // Create sample artisan profiles
        $artisans = [
            [
                'name' => 'John Carpenter',
                'email' => 'john@example.com',
                'description' => 'Specializing in handcrafted wooden furniture with over 15 years of experience.',
                'rating' => 4.8,
            ],
            [
                'name' => 'Mary Potter',
                'email' => 'mary@example.com',
                'description' => 'Creating beautiful ceramic pottery inspired by traditional African designs.',
                'rating' => 4.5,
            ],
            [
                'name' => 'Samuel Smith',
                'email' => 'samuel@example.com',
                'description' => 'Master blacksmith crafting unique metal art pieces and functional items.',
                'rating' => 4.9,
            ],
            [
                'name' => 'Elizabeth Weaver',
                'email' => 'liz@example.com',
                'description' => 'Expert in traditional textile weaving with modern twists.',
                'rating' => 4.7,
            ],
            [
                'name' => 'David Jeweler',
                'email' => 'david@example.com',
                'description' => 'Creating exquisite handmade jewelry using ethically sourced materials.',
                'rating' => 4.6,
            ],
            [
                'name' => 'Grace Tailor',
                'email' => 'grace@example.com',
                'description' => 'Skilled tailor specializing in custom clothing and alterations.',
                'rating' => 4.4,
            ]
        ];

        foreach ($artisans as $artisanData) {
            // Create user first
            $user = User::firstOrCreate(
                ['email' => $artisanData['email']],
                [
                    'name' => $artisanData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'artisan'
                ]
            );

            // Create artisan profile
            ArtisanProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $artisanData['name'],
                    'description' => $artisanData['description'],
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'city' => $cities[array_rand($cities)],
                    'state' => 'Sample State',
                    'rating' => $artisanData['rating'],
                    'reviews_count' => rand(5, 50),
                ]
            );
        }
    }
}
