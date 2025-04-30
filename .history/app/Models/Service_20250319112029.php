<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration',
        'image',
        'is_active',
        'artisan_profile_id', // Changed from user_id
        'category_id',
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
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class);
    }

    /**
     * Get the artisan (user) that owns the service through their profile.
     */
    public function artisan()
    {
        return $this->hasOneThrough(User::class, ArtisanProfile::class, 'id', 'id', 'artisan_profile_id', 'user_id');
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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
