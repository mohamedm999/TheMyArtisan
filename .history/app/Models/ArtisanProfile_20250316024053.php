<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtisanProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profession',
        'about_me',
        'experience_years',
        'hourly_rate',
        'skills',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'business_name',
        'business_registration_number',
        'insurance_details',
        'profile_photo',
        'category_id',
        'rating'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'skills' => 'array',
        'hourly_rate' => 'float',
        'rating' => 'float',
    ];

    /**
     * Get the user that owns the artisan profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the artisan.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the work experiences for the artisan.
     */
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    /**
     * Get the certifications for the artisan.
     */
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the reviews for the artisan.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the full address attribute.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $parts = [];
        if (!empty($this->address)) $parts[] = $this->address;
        if (!empty($this->city)) $parts[] = $this->city;
        if (!empty($this->country)) $parts[] = $this->country;
        if (!empty($this->postal_code)) $parts[] = $this->postal_code;

        return !empty($parts) ? implode(', ', $parts) : null;
    }
}
