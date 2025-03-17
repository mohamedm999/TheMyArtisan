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
        'zip',
        'country',
        'bio',
        'preferred_language',
        'notification_preferences',
        'preferred_contact_time',
        'latitude',
        'longitude',
        'service_radius',
        'preferred_payment_methods',
        'favorite_categories',
        'profile_visibility',
        'emergency_contact_name',
        'emergency_contact_phone',
        'tax_identification',
        'birth_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'notification_preferences' => 'array',
        'preferred_payment_methods' => 'array',
        'favorite_categories' => 'array',
        'birth_date' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
        'service_radius' => 'float',
    ];

    /**
     * Get the user that owns the client profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the saved artisans for this client.
     */
    public function savedArtisans()
    {
        return $this->belongsToMany(User::class, 'saved_artisans', 'client_id', 'artisan_id')
                    ->withTimestamps();
    }

    /**
     * Get the client's bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'client_id', 'user_id');
    }
}
