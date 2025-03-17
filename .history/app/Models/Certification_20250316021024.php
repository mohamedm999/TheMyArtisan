<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_profile_id',
        'user_id',
        'name',
        'issuer',
        'valid_until'
    ];

    /**
     * Get the artisan profile that owns the certification.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class);
    }

    /**
     * Accessor for compatibility with view templates
     */
    public function getTitleAttribute()
    {
        return $this->name;
    }

    /**
     * Accessor for compatibility with view templates
     */
    public function getIssuingOrganizationAttribute()
    {
        return $this->issuer;
    }

    /**
     * Accessor for compatibility with view templates
     */
    public function getExpiryDateAttribute()
    {
        return $this->valid_until;
    }
}
