<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtisanService extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_profile_id',
        'name',
        'description',
        'category',
        'price',
        'duration',
        'is_available'
    ];

    /**
     * Get the artisan profile that owns the service.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class);
    }
}
