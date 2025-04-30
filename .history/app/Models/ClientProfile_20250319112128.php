<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
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
        'preferences',
        'bio',
    ];

    protected $casts = [
        'preferences' => 'json',
    ];

    /**
     * Get the user that owns the client profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookings for the client profile.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'client_profile_id');
    }

    /**
     * Get the reviews given by the client profile.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_profile_id');
    }
}
