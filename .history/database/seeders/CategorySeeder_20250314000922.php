<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
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
                'subcategories' => [
                    [
                        'name' => 'Plumbing',
                        'description' => 'Installation, repair and maintenance of water systems',
                        'icon' => 'fa-faucet',
                    ],
                    [
                        'name' => 'Electrical Work',
                        'description' => 'Installation and repair of electrical systems and fixtures',
                        'icon' => 'fa-bolt',
                    ],
                    [
                        'name' => 'Carpentry',
                        'description' => 'Custom woodworking and furniture making',
                        'icon' => 'fa-hammer',
                    ],
                    [
                        'name' => 'Painting',
                        'description' => 'Interior and exterior painting services',
                        'icon' => 'fa-paint-roller',
                    ]
                ]
            ],
            [
                'name' => 'Cleaning & Maintenance',
                'description' => 'Professional cleaning and maintenance services',
                'icon' => 'fa-broom',
                'subcategories' => [
                    [
                        'name' => 'House Cleaning',
                        'description' => 'Regular and deep cleaning services for homes',
                        'icon' => 'fa-spray-can',
                    ],
                    [
                        'name' => 'Garden Maintenance',
                        'description' => 'Lawn care, trimming, and garden upkeep',
                        'icon' => 'fa-leaf',
                    ],
                    [
                        'name' => 'Pool Maintenance',
                        'description' => 'Cleaning and maintaining swimming pools',
                        'icon' => 'fa-swimming-pool',
                    ]
                ]
            ],
            [
                'name' => 'Craftwork & Restoration',
                'description' => 'Artisanal handcrafts and restoration services',
                'icon' => 'fa-tools',
                'subcategories' => [
                    [
                        'name' => 'Furniture Restoration',
                        'description' => 'Repair and restoration of antique and vintage furniture',
                        'icon' => 'fa-chair',
                    ],
                    [
                        'name' => 'Custom Jewelry',
                        'description' => 'Handcrafted jewelry and custom designs',
                        'icon' => 'fa-gem',
                    ],
                    [
                        'name' => 'Ceramic & Pottery',
                        'description' => 'Custom pottery making and ceramic repair',
                        'icon' => 'fa-palette',
                    ]
                ]
            ],
            [
                'name' => 'Automotive',
                'description' => 'Vehicle maintenance and repair services',
                'icon' => 'fa-car',
                'subcategories' => [
                    [
                        'name' => 'Car Detailing',
                        'description' => 'Professional cleaning and detailing of vehicles',
                        'icon' => 'fa-car-side',
                    ],
                    [
                        'name' => 'Mobile Mechanic',
                        'description' => 'On-location auto repair and maintenance services',
                        'icon' => 'fa-wrench',
                    ]
                ]
            ],
            [
                'name' => 'Food & Culinary',
                'description' => 'Food preparation and culinary services',
                'icon' => 'fa-utensils',
                'subcategories' => [
                    [
                        'name' => 'Private Chef',
                        'description' => 'Personal chef services for events or regular meals',
                        'icon' => 'fa-hat-chef',
                    ],
                    [
                        'name' => 'Baking & Pastries',
                        'description' => 'Custom baked goods and pastries',
                        'icon' => 'fa-bread-slice',
                    ],
                    [
                        'name' => 'Catering',
                        'description' => 'Food preparation and service for events',
                        'icon' => 'fa-concierge-bell',
                    ]
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'] ?? [];
            unset($categoryData['subcategories']);

            // Create the main category
            $categoryData['slug'] = Str::slug($categoryData['name']);
            $category = Category::create($categoryData);

            // Create subcategories
            foreach ($subcategories as $subcategoryData) {
                $subcategoryData['slug'] = Str::slug($subcategoryData['name']);
                $subcategoryData['parent_id'] = $category->id;
                Category::create($subcategoryData);
            }
        }
    }
}
