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
}
