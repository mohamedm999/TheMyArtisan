<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_profile_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'booking_id',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the artisan profile that the availability belongs to.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class);
    }

    /**
     * Get the booking associated with this availability slot.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
