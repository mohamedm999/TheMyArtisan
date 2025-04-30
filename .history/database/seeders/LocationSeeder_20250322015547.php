<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            [
                'name' => 'Marrakech',
                'country' => 'Morocco',
                'region' => 'Marrakech-Safi',
                'city' => 'Marrakech',
                'latitude' => 31.6295,
                'longitude' => -7.9811,
                'description' => 'The cultural heart of Morocco, known for its vibrant medina and traditional craftsmanship.'
            ],
            [
                'name' => 'Fez',
                'country' => 'Morocco',
                'region' => 'Fès-Meknès',
                'city' => 'Fez',
                'latitude' => 34.0181,
                'longitude' => -5.0078,
                'description' => 'Famous for its ancient walled medina and traditional leather tanneries.'
            ],
            [
                'name' => 'Casablanca',
                'country' => 'Morocco',
                'region' => 'Casablanca-Settat',
                'city' => 'Casablanca',
                'latitude' => 33.5731,
                'longitude' => -7.5898,
                'description' => 'Morocco\'s largest city and economic hub.'
            ],
            [
                'name' => 'Rabat',
                'country' => 'Morocco',
                'region' => 'Rabat-Salé-Kénitra',
                'city' => 'Rabat',
                'latitude' => 34.0209,
                'longitude' => -6.8416,
                'description' => 'The capital city of Morocco, known for its Islamic and French-colonial heritage.'
            ],
            [
                'name' => 'Tangier',
                'country' => 'Morocco',
                'region' => 'Tanger-Tétouan-Al Hoceima',
                'city' => 'Tangier',
                'latitude' => 35.7595,
                'longitude' => -5.8340,
                'description' => 'A port city on the Strait of Gibraltar, known for its diverse culture.'
            ],
            [
                'name' => 'Essaouira',
                'country' => 'Morocco',
                'region' => 'Marrakech-Safi',
                'city' => 'Essaouira',
                'latitude' => 31.5085,
                'longitude' => -9.7595,
                'description' => 'A coastal city known for its medina, windy beaches, and woodworking traditions.'
            ],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ['name' => $location['name'], 'country' => $location['country']],
                [
                    'slug' => Str::slug($location['name'] . '-' . $location['country']),
                    'region' => $location['region'],
                    'city' => $location['city'],
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                    'description' => $location['description'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Locations seeded successfully!');
    }
}
