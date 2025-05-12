<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Zellige & Tilework',
                'description' => 'Traditional Moroccan mosaic tile craftsmanship',
                'image' => 'zellige_tilework.jpg',
            ],
            [
                'name' => 'Woodworking & Cedar Craft',
                'description' => 'Hand-carved wooden furniture and decor',
                'image' => 'woodworking_cedar_craft.jpg',
            ],
            [
                'name' => 'Metal Engraving & Brasswork',
                'description' => 'Engraved brass and copper crafts',
                'image' => 'metal_engraving_brasswork.jpg',
            ],
            [
                'name' => 'Leatherwork & Tannery',
                'description' => 'Handmade leather goods from Fez tanneries',
                'image' => 'leatherwork_tannery.jpg',
            ],
            [
                'name' => 'Pottery & Ceramics',
                'description' => 'Safi pottery and hand-painted ceramics',
                'image' => 'pottery_ceramics.jpg',
            ],
            [
                'name' => 'Weaving & Textiles',
                'description' => 'Handwoven Berber rugs and silk embroidery',
                'image' => 'weaving_textiles.jpg',
            ],
            [
                'name' => 'Jewelry & Silverwork',
                'description' => 'Traditional Amazigh silver jewelry',
                'image' => 'jewelry_silverwork.jpg',
            ],
            [
                'name' => 'Plaster & Gypsum Art',
                'description' => 'Intricate Moroccan plaster and gypsum carvings',
                'image' => 'plaster_gypsum_art.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'image' => $category['image'],
                    'slug' => Str::slug($category['name'])
                ]
            );
        }
    }
}
