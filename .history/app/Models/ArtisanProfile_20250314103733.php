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
        'skills',
        'experience_years',
        'hourly_rate',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'location_coordinates',
        'availability_hours',
        'business_name',
        'business_registration_number',
        'insurance_details',
        'is_verified',
        'profile_photo',
        'cover_photo',
        'profile_image',
        'cover_image',
    ];

    protected $casts = [
        'skills' => 'array',
        'availability_hours' => 'array',
        'is_verified' => 'boolean',
        'hourly_rate' => 'float',
        'experience_years' => 'integer',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the work experiences for this artisan.
     */
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class, 'user_id', 'user_id');
    }

    /**
     * Get the certifications for this artisan.
     */
    public function certifications()
    {
        return $this->hasMany(Certification::class, 'user_id', 'user_id');
    }

    /**
     * Get formatted address.
     */
    public function getFullAddressAttribute()
    {
        $parts = [];
        if ($this->address) $parts[] = $this->address;
        if ($this->city) $parts[] = $this->city;
        if ($this->country) $parts[] = $this->country;
        if ($this->postal_code) $parts[] = $this->postal_code;

        return implode(', ', $parts);
    }

    /**
     * Get formatted skills list.
     */
    public function getFormattedSkillsAttribute()
    {
        return $this->skills ? implode(', ', $this->skills) : '';
    }
}
