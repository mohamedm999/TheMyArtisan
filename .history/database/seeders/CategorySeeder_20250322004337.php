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

        foreach ($categories as $category) {
            // Copy placeholder images to storage if they don't exist
            $imageName = $category['image'];
            $sourcePath = public_path('img/categories/' . $imageName);
            $destinationPath = $categoryImagesPath . '/' . $imageName;

            // Create a placeholder image if source doesn't exist
            if (!File::exists($sourcePath)) {
                $this->createPlaceholderImage($categoryImagesPath, $imageName);
                $this->command->info('Created placeholder image for: ' . $category['name']);
            } else if (!File::exists($destinationPath)) {
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
     * Create a simple colored placeholder image if actual image doesn't exist
     */
    private function createPlaceholderImage($path, $filename)
    {
        // Create a simple 300x200 placeholder with category name
        $img = imagecreatetruecolor(300, 200);

        // Use a different color for each category based on filename
        $hash = md5($filename);
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));

        // Make color a bit lighter for better visibility
        $color = imagecolorallocate($img, min($r + 100, 255), min($g + 100, 255), min($b + 100, 255));
        $textColor = imagecolorallocate($img, 33, 33, 33);

        // Fill background
        imagefill($img, 0, 0, $color);

        // Add some text (category name)
        $categoryName = str_replace(['_', '.jpg'], [' ', ''], $filename);
        $font = 5; // built-in font
        $textWidth = imagefontwidth($font) * strlen($categoryName);
        $textHeight = imagefontheight($font);

        // Center text
        $x = (300 - $textWidth) / 2;
        $y = (200 - $textHeight) / 2;

        // Write text
        imagestring($img, $font, $x, $y, $categoryName, $textColor);

        // Save image
        imagejpeg($img, $path . '/' . $filename, 90);
        imagedestroy($img);
    }
}
