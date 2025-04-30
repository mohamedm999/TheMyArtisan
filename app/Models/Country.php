<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the cities for this country.
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get the artisan profiles for this country.
     */
    public function artisanProfiles()
    {
        return $this->hasMany(ArtisanProfile::class);
    }
}
