<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_profile_id',
        'user_id',
        'company_name',
        'position',
        'start_date',
        'end_date',
        'is_current',
        'description'
    ];

    /**
     * Get the artisan profile that owns the work experience.
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
        return $this->position;
    }

    /**
     * Accessor for compatibility with view templates
     */
    public function getCompanyAttribute()
    {
        return $this->company_name;
    }
}
