<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_profile_id',
        'name',
        'issuer',
        'valid_until',
        'credential_id',
        'credential_url',
        'description',
        'user_id',
        'title',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'verification_status',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get the artisan profile that owns the certification.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class);
    }

    /**
     * Get the user that owns the certification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
