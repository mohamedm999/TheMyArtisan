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
        'verification_document',
        'profession',
        'about_me',
        'experience_years',
        'hourly_rate',
        'skills',
        'country',
        'business_registration_number',
        'insurance_details'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'skills' => 'array',
        'is_verified' => 'boolean',
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
     * Get the certifications for the artisan.
     */
    public function certifications()
    {
        return $this->hasMany(Certification::class, 'artisan_profile_id');
    }

    /**
     * Get the work experiences for the artisan.
     */
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class, 'artisan_profile_id');
    }

    pu

    /**
     * Get the formatted full address.
     */
    public function getFullAddressAttribute()
    {
        $parts = [];
        if ($this->address) $parts[] = $this->address;
        if ($this->city) $parts[] = $this->city;
        if ($this->state) $parts[] = $this->state;
        if ($this->postal_code) $parts[] = $this->postal_code;
        if ($this->country) $parts[] = $this->country;

        return count($parts) > 0 ? implode(', ', $parts) : null;
    }
}
