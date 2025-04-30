<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'points',
        'type',
        'description',
        'transactionable_id',
        'transactionable_type'
    ];

    /**
     * Transaction types constants
     */
    const TYPE_EARNED = 'earned';
    const TYPE_SPENT = 'spent';
    const TYPE_EXPIRED = 'expired';
    const TYPE_REFUNDED = 'refunded';
    const TYPE_ADJUSTED = 'adjusted';

    /**
     * Get the user that owns this transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent transactionable model (polymorphic).
     */
    public function transactionable()
    {
        return $this->morphTo();
    }
}
