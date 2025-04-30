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
    public function hasRole($roleName)
    {
        // First method: If using is_admin for admin privileges
        if ($roleName === 'admin' && $this->is_admin) {
            return true;
        }

        // If admin users should have all permissions
        if ($this->is_admin) {
            return true;
        }

        // Second method: If using a roles relationship
        if (method_exists($this, 'roles')) {
            return $this->roles->pluck('name')->contains($roleName);
        }

        // Third method: If roles are stored in a single field (comma separated)
        if (isset($this->role)) {
            return in_array($roleName, explode(',', $this->role));
        }

        return false;
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
