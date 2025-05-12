<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create categories directory in storage if it doesn't exist
        $categoryImagesPath = storage_path('app/public/categories');
        if (!File::exists($categoryImagesPath)) {
            File::makeDirectory($categoryImagesPath, 0755, true);
        }

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

        // First, copy the default placeholder image to use when needed
        $this->createDefaultPlaceholder($categoryImagesPath);

        foreach ($categories as $category) {
            // Set up image name
            $imageName = $category['image'];
            $sourcePath = public_path('images/categories/' . $imageName);
            $destinationPath = $categoryImagesPath . '/' . $imageName;

            // Check if we need to use a placeholder
            if (!File::exists($sourcePath) && !File::exists($destinationPath)) {
                // Use the default placeholder but rename it to the category's image name
                File::copy($categoryImagesPath . '/placeholder.jpg', $destinationPath);
                $this->command->info('Created placeholder image for: ' . $category['name']);
            } else if (File::exists($sourcePath) && !File::exists($destinationPath)) {
                // Copy existing image to storage
                File::copy($sourcePath, $destinationPath);
                $this->command->info('Copied image for: ' . $category['name']);
            }

            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'image' => $imageName,
                    'slug' => Str::slug($category['name']),
                    'is_active' => true
                ]
            );
        }

        $this->command->info('Categories seeded successfully!');
    }

    /**
     * Create a default placeholder image to use for categories
     */
    private function createDefaultPlaceholder($path)
    {
        $placeholderPath = $path . '/placeholder.jpg';

        // If placeholder already exists, no need to create it again
        if (File::exists($placeholderPath)) {
            return;
        }

        // First check if we have a placeholder in the public images folder
        $publicPlaceholder = public_path('images/placeholder.jpg');

        if (File::exists($publicPlaceholder)) {
            // Copy the existing placeholder
            File::copy($publicPlaceholder, $placeholderPath);
        } else {
            // Create a simple text file as a placeholder (not ideal, but works without GD)
            $content = "This is a placeholder for a category image. Please replace with an actual image.";
            File::put($placeholderPath, $content);

            $this->command->info('Created a default placeholder file.');
        }
    }
}
