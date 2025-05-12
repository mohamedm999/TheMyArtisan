<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration',
        'image',
        'is_active',
        'user_id', // Changed from artisan_id
        'category_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'float',
        'duration' => 'integer',
    ];

    /**
     * Get the artisan that owns the service.
     */
    public function artisan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category that the service belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
