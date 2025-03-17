<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_id',
        'date',
        'start_time',
        'end_time',
        'status', // available, booked, unavailable
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
        return $this->belongsTo(User::class, 'artisan_id');
    }

    /**
     * Get the booking associated with this availability.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
