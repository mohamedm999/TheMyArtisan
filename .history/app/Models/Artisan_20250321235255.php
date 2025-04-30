<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artisan extends Model
{
    // ...existing code...

    /**
     * Get the categories that belong to the artisan.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'artisan_category')
            ->withTimestamps();
    }

    // ...existing code...
}
