<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_profile_id', // Changed from artisan_profiles_id to artisan_profile_id
        'company_name',
        'position',
        'start_date',
        'end_date',
        'description',
        'is_current',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Get the artisan profile that owns the work experience.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class, 'artisan_profile_id');
    }
}
