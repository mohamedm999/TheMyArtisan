<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'store_product_id',
        'quantity',
        'points_spent',
        'status',
        'delivery_details',
        'tracking_number',
        'redeemed_at'
    ];

    /**
     * Order status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'redeemed_at' => 'datetime',
        'delivery_details' => 'array',
    ];

    /**
     * Get the user that owns this order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with this order.
     */
    public function product()
    {
        return $this->belongsTo(StoreProduct::class, 'store_product_id');
    }

    /**
     * Get the point transaction record associated with this order.
     */
    public function pointTransaction()
    {
        return $this->morphOne(PointTransaction::class, 'transactionable');
    }
}
