<?php

// Run this script manually to clean the categories table before seeding
// php artisan tinker < database/fix-categories-issue.php

use Illuminate\Support\Facades\DB;

// Remove existing categories to avoid duplicate slug issues
DB::table('categories')->truncate();

echo "Categories table truncated. You can now run the seeder.";
