<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtisanProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'city',
        'state',
        'location',
        'category_id',
        'rating',
        'is_verified',
        'profile_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'float',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the user that owns the artisan profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category associated with the artisan profile.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the skills for the artisan profile.
     */
    public function skills()
    {
        return $this->hasMany(Skill::class, 'artisan_profile_id');
    }

    /**
     * Get the reviews for the artisan profile.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'artisan_profile_id');
    }

    /**
     * Get the portfolio for the artisan profile.
     */
    public function portfolio()
    {
        return $this->hasMany(PortfolioItem::class, 'artisan_profile_id');
    }
}
