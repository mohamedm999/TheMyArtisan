<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'points_cost',
        'image',
        'category',
        'is_featured',
        'is_available',
        'stock'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'is_available' => 'boolean',
    ];

    /**
     * Get the orders for this product.
     */
    public function orders()
    {
        return $this->hasMany(ProductOrder::class);
    }

    /**
     * Check if the product is in stock.
     *
     * @return bool
     */
    public function isInStock()
    {
        // -1 means unlimited stock
        return $this->stock === -1 || $this->stock > 0;
    }
}
