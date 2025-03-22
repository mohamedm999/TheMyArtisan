<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    use HasFactory;

    // ...existing code...

    /**
     * The categories that belong to the artisan.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Assign a category to the artisan.
     */
    public function assignCategory($category)
    {
        if (is_numeric($category)) {
            return $this->categories()->syncWithoutDetaching([$category]);
        }

        return $this->categories()->syncWithoutDetaching([$category->id]);
    }

    /**
     * Remove a category from the artisan.
     */
    public function removeCategory($category)
    {
        if (is_numeric($category)) {
            return $this->categories()->detach([$category]);
        }

        return $this->categories()->detach([$category->id]);
    }

    // ...existing code...
}
