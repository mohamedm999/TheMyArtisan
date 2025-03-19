<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'service_id',
        'client_profile_id',
        'artisan_profile_id',
        'rating',
        'comment',
        'response',
        'response_date',
        'reported',
        'report_reason',
        'report_date',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'response_date' => 'datetime',
        'report_date' => 'datetime',
        'reported' => 'boolean',
    ];

    /**
     * Get the booking that the review is for.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the service that the review is for.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the client profile who wrote the review.
     */
    public function clientProfile()
    {
        return $this->belongsTo(ClientProfile::class, 'client_profile_id');
    }

    /**
     * Get the client user who wrote the review.
     */
    public function client()
    {
        return $this->hasOneThrough(User::class, ClientProfile::class, 'id', 'id', 'client_profile_id', 'user_id');
    }

    /**
     * Get the artisan profile who received the review.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_profile_id');
    }

    /**
     * Get the artisan user who received the review.
     */
    public function artisan()
    {
        return $this->hasOneThrough(User::class, ArtisanProfile::class, 'id', 'id', 'artisan_profile_id', 'user_id');
    }
}
