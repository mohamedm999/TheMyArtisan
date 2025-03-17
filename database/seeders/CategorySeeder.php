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
                'name' => 'Home Improvement',
                'description' => 'Services related to home improvement and renovation',
                'icon' => 'fa-home',
                'parent_id' => null,
            ],
            [
                'name' => 'Cleaning & Maintenance',
                'description' => 'Professional cleaning and maintenance services',
                'icon' => 'fa-broom',
                'parent_id' => null,
            ],
            [
                'name' => 'Craftwork & Restoration',
                'description' => 'Artisanal handcrafts and restoration services',
                'icon' => 'fa-tools',
                'parent_id' => null,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Vehicle maintenance and repair services',
                'icon' => 'fa-car',
                'parent_id' => null,
            ],
            [
                'name' => 'Food & Culinary',
                'description' => 'Food preparation and culinary services',
                'icon' => 'fa-utensils',
                'parent_id' => null,
            ],
        ];

        foreach ($categories as $category) {
            // Generate slug if not provided
            if (!isset($category['slug'])) {
                $category['slug'] = Str::slug($category['name']);
            }

            // Use updateOrCreate to handle duplicates
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        // For subcategories with parent relationships
        $subcategories = [
            [
                'name' => 'Plumbing',
                'description' => 'Installation, repair and maintenance of water systems',
                'icon' => 'fa-faucet',
                'parent_slug' => 'home-improvement', // Reference to parent by slug
            ],
            [
                'name' => 'Electrical Work',
                'description' => 'Installation and repair of electrical systems and fixtures',
                'icon' => 'fa-bolt',
                'parent_slug' => 'home-improvement',
            ],
            [
                'name' => 'Carpentry',
                'description' => 'Custom woodworking and furniture making',
                'icon' => 'fa-hammer',
                'parent_slug' => 'home-improvement',
            ],
            [
                'name' => 'Painting',
                'description' => 'Interior and exterior painting services',
                'icon' => 'fa-paint-roller',
                'parent_slug' => 'home-improvement',
            ],
            [
                'name' => 'House Cleaning',
                'description' => 'Regular and deep cleaning services for homes',
                'icon' => 'fa-spray-can',
                'parent_slug' => 'cleaning-maintenance',
            ],
            [
                'name' => 'Garden Maintenance',
                'description' => 'Lawn care, trimming, and garden upkeep',
                'icon' => 'fa-leaf',
                'parent_slug' => 'cleaning-maintenance',
            ],
            [
                'name' => 'Pool Maintenance',
                'description' => 'Cleaning and maintaining swimming pools',
                'icon' => 'fa-swimming-pool',
                'parent_slug' => 'cleaning-maintenance',
            ],
            [
                'name' => 'Furniture Restoration',
                'description' => 'Repair and restoration of antique and vintage furniture',
                'icon' => 'fa-chair',
                'parent_slug' => 'craftwork-restoration',
            ],
            [
                'name' => 'Custom Jewelry',
                'description' => 'Handcrafted jewelry and custom designs',
                'icon' => 'fa-gem',
                'parent_slug' => 'craftwork-restoration',
            ],
            [
                'name' => 'Ceramic & Pottery',
                'description' => 'Custom pottery making and ceramic repair',
                'icon' => 'fa-palette',
                'parent_slug' => 'craftwork-restoration',
            ],
            [
                'name' => 'Car Detailing',
                'description' => 'Professional cleaning and detailing of vehicles',
                'icon' => 'fa-car-side',
                'parent_slug' => 'automotive',
            ],
            [
                'name' => 'Mobile Mechanic',
                'description' => 'On-location auto repair and maintenance services',
                'icon' => 'fa-wrench',
                'parent_slug' => 'automotive',
            ],
            [
                'name' => 'Private Chef',
                'description' => 'Personal chef services for events or regular meals',
                'icon' => 'fa-hat-chef',
                'parent_slug' => 'food-culinary',
            ],
            [
                'name' => 'Baking & Pastries',
                'description' => 'Custom baked goods and pastries',
                'icon' => 'fa-bread-slice',
                'parent_slug' => 'food-culinary',
            ],
            [
                'name' => 'Catering',
                'description' => 'Food preparation and service for events',
                'icon' => 'fa-concierge-bell',
                'parent_slug' => 'food-culinary',
            ],
        ];

        foreach ($subcategories as $subcategory) {
            // Generate slug if not provided
            if (!isset($subcategory['slug'])) {
                $subcategory['slug'] = Str::slug($subcategory['name']);
            }

            // Find parent by slug
            $parent = null;
            if (isset($subcategory['parent_slug'])) {
                $parent = Category::where('slug', $subcategory['parent_slug'])->first();
                if ($parent) {
                    $subcategory['parent_id'] = $parent->id;
                }
                unset($subcategory['parent_slug']);
            }

            // Use updateOrCreate to handle duplicates
            Category::updateOrCreate(
                ['slug' => $subcategory['slug']],
                $subcategory
            );
        }
    }
}
