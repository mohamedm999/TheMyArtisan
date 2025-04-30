<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;

class CountryCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add some common countries
        $countries = [
            ['name' => 'Morocco', 'code' => 'MAR'],
            ['name' => 'France', 'code' => 'FRA'],
            ['name' => 'Spain', 'code' => 'ESP'],
            ['name' => 'United Kingdom', 'code' => 'GBR'],
            ['name' => 'United States', 'code' => 'USA'],
            ['name' => 'Germany', 'code' => 'DEU'],
            ['name' => 'Italy', 'code' => 'ITA'],
        ];

        foreach ($countries as $countryData) {
            Country::updateOrCreate(
                ['code' => $countryData['code']],
                ['name' => $countryData['name'], 'is_active' => true]
            );
        }

        // Add Morocco cities
        $morocco = Country::where('code', 'MAR')->first();
        $moroccoCities = [
            'Casablanca', 'Rabat', 'Marrakech', 'Fez', 'Tangier',
            'Agadir', 'Meknes', 'Oujda', 'Kenitra', 'Tetouan',
            'Essaouira', 'Chefchaouen', 'El Jadida', 'Taroudant', 'Ouarzazate'
        ];

        foreach ($moroccoCities as $cityName) {
            City::updateOrCreate(
                ['name' => $cityName, 'country_id' => $morocco->id],
                ['is_active' => true]
            );
        }

        // Add French cities
        $france = Country::where('code', 'FRA')->first();
        $frenchCities = [
            'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice',
            'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille'
        ];

        foreach ($frenchCities as $cityName) {
            City::updateOrCreate(
                ['name' => $cityName, 'country_id' => $france->id],
                ['is_active' => true]
            );
        }

        $this->command->info('Countries and cities seeded successfully!');
    }
}
