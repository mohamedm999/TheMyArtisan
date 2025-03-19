<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'artisan_id',
        'artisan_profiles_id',
        // Add other fillable fields here
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'float',
        'duration' => 'integer',
    ];

    /**
     * Get the artisan profile that owns the service.
     * Support both column names for backward compatibility
     */
    public function artisan()
    {
        // Try with artisan_profiles_id first, fall back to artisan_id
        if (Schema::hasColumn('services', 'artisan_profiles_id')) {
            return $this->belongsTo(ArtisanProfile::class, 'artisan_profiles_id');
        }

        return $this->belongsTo(ArtisanProfile::class, 'artisan_id');
    }

    /**
     * Get the category that the service belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
