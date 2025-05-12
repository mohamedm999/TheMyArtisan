<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_profile_id', // Make sure this is not artisan_profiles_id
        'title',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'credential_id',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get the artisan profile that owns the certification.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_profile_id');
    }
}
