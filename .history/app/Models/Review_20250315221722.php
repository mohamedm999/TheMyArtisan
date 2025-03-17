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
        'customer_id',
        'artisan_id',
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
     * Get the customer who wrote the review.
     */
    public function customer()
    {
        return $this->belongsTo(::class, 'customer_id');
    }

    /**
     * Get the artisan who received the review.
     */
    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }
}
