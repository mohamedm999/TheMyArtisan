<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_profile_id',
        'position',
        'company_name',
        'start_date',
        'end_date',
        'is_current',
        'description',
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
        return $this->belongsTo(ArtisanProfile::class);
    }
}
