<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtisanProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'profile_photo',
        'bio',
        'skills',
        'years_experience',
        'service_radius',
        'availability',
        'city_id',
        'country_id',
        's'
    ];

    protected $casts = [
        'skills' => 'array',
        'availability' => 'array',
        'years_experience' => 'integer',
    ];

    /**
     * Get the user that owns the artisan profile.
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
        return $this->hasMany(Service::class);
    }

    /**
     * Get the bookings for the artisan profile.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for the artisan profile.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'artisan_profile_id');
    }

    /**
     * Get the certifications for the artisan profile.
     */
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the work experiences for the artisan profile.
     */
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class, 'artisan_profile_id');
    }

    /**
     * Get the availabilities for the artisan profile.
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * The categories that belong to the artisan profile.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'artisan_category');
    }

    /**
     * Get the city that the artisan profile belongs to.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the country that the artisan profile belongs to.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the users who have saved this artisan profile.
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_artisans', 'artisan_profile_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Calculate the average rating for this artisan from all reviews.
     *
     * @return float
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    /**
     * Get the total number of reviews for this artisan.
     *
     * @return int
     */
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }
}
