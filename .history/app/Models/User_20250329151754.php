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
     * User status constants
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_PENDING = 'pending';

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
        'status',
        'role',
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
     * @param string|Role $role
     * @return boolean
     */
    public function hasRole($role)
    {
        // First check direct role attribute (used by middleware)
        if (is_string($role) && strcasecmp($this->role, $role) === 0) {
            return true;
        }

        // Check if roles relation is loaded - if not, load it to avoid multiple queries
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }

        // Check if the role is a string (role name)
        if (is_string($role)) {
            return $this->roles->where('name', $role)->count() > 0;
        }

        // If it's a Role model instance
        if ($role instanceof Role) {
            return $this->roles->contains('id', $role->id);
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

    /**
     * Check if user is active.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include inactive users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', '!=', self::STATUS_ACTIVE);
    }

    /**
     * Deactivate the user.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->update(['status' => self::STATUS_INACTIVE]);
        return $this;
    }

    /**
     * Activate the user.
     *
     * @return $this
     */
    public function activate()
    {
        $this->update(['status' => self::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * Suspend the user.
     *
     * @return $this
     */
    public function suspend()
    {
        $this->update(['status' => self::STATUS_SUSPENDED]);
        return $this;
    }
}
