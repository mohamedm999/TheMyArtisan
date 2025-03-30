<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if user has a specific role
     *
     * @param string $roleName
     * @return boolean
     */
    public function hasRole($role)
    {
        // If is_admin is set to true, user has all roles
        if ($this->is_admin) {
            return true;
        }

        // For string role names, use a direct query instead of collection
        if (is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }

        // If it's a single Role model instance
        if ($role instanceof Role) {
            return $this->roles()->where('roles.id', $role->id)->exists();
        }

        return false;
    }

    /**
     * Get the URL of the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->artisanProfile && $this->artisanProfile->profile_photo) {
            return asset('storage/' . $this->artisanProfile->profile_photo);
        }

        if ($this->clientProfile && $this->clientProfile->profile_photo) {
            return asset('storage/' . $this->clientProfile->profile_photo);
        }

        // Return default avatar if no profile photo exists
        return asset('images/default-profile.jpg');
    }

    /**
     * Get the phone number from the appropriate profile
     *
     * @return string|null
     */
    public function getPhoneAttribute()
    {
        if ($this->artisanProfile) {
            return $this->artisanProfile->phone;
        }

        if ($this->clientProfile) {
            return $this->clientProfile->phone;
        }

        return null;
    }

    /**
     * Get the artisan profile associated with the user.
     */
    public function artisanProfile()
    {
        return $this->hasOne(ArtisanProfile::class);
    }

    /**
     * Get the client profile associated with the user.
     */
    public function clientProfile()
    {
        return $this->hasOne(ClientProfile::class);
    }

    /**
     * Get the artisans saved by this user (client).
     */
    public function savedArtisans()
    {
        return $this->belongsToMany(ArtisanProfile::class, 'saved_artisans', 'user_id', 'artisan_profile_id')
            ->withTimestamps();
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        if (!$this->hasRole($role)) {
            $this->roles()->attach($role);
        }

        return $this;
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        $this->roles()->detach($role);

        return $this;
    }
}
