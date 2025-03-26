<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedArtisan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'artisan_profile_id',
    ];

    /**
     * Get the user that saved this artisan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the artisan profile that was saved.
     */
    public function artisanProfile()
    {
        return $this->belongsTo(ArtisanProfile::class);
    }
}
