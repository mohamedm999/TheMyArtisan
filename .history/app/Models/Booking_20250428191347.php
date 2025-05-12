<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_profile_id',
        'artisan_profile_id',
        'service_id',
        'booking_date',
        'status',
        'notes',
    ];

    // Add date casting to ensure booking_date is always a Carbon instance
    protected $casts = [
        'booking_date' => 'datetime',
    ];

    public function clientProfile()
    {
        return $this->belongsTo(ClientProfile::class, 'client_profile_id');
    }

    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_profile_id');
    }

    // Get the actual client user through the profile
    public function client()
    {
        return $this->hasOneThrough(User::class, ClientProfile::class, 'id', 'id', 'client_profile_id', 'user_id');
    }

    // Get the actual artisan user through the profile
    public function artisan()
    {
        return $this->hasOneThrough(User::class, ArtisanProfile::class, 'id', 'id', 'artisan_profile_id', 'user_id');
    }

    /**
     * Get the service that the booking is for.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the review associated with this booking.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the availability slot associated with this booking. Added based on diagram.
     */
    public function availability()
    {
        // Assuming one booking reserves one availability slot
        return $this->hasOne(Availability::class);
        // Or belongsTo if the foreign key `booking_id` is on the Availability table
        // return $this->belongsTo(Availability::class); // Check migration if unsure
        // Based on Availability model having belongsTo(Booking), Booking should have hasOne(Availability)
    }

    /**
     * Check if this booking has been reviewed by the client.
     *
     * @return bool
     */
    public function hasReview()
    {
        return $this->review()->exists();
    }
}
