<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtisanProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'business_name',
        'years_of_experience',
        'profile_photo',
        'is_verified',
        'verification_document'
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the services for the artisan profile.
     */
    public function services()
    {
        return $this->hasMany(ArtisanService::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the category that the artisan belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the skills for the artisan.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'artisan_skill');
    }

    /**
     * Get the portfolio items for the artisan.
     */
    public function portfolio()
    {
        return $this->hasMany(PortfolioItem::class);
    }

    /**
     * Get the certifications for the artisan.
     */
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the work experiences for the artisan.
     */
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }
}
