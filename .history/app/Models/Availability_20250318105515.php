<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'artisan_profiles_id', // Add this to fillable
        'date',
        'start_time',
        'end_time',
        'status',
        'booking_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the artisan that owns the availability.
     */
    public function artisan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the artisan profile that owns the availability.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_profiles_id');
    }

    /**
     * Get the booking associated with this availability.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
