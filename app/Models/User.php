<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'locale',
        'is_super_admin',
        'current_business_id',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_super_admin' => 'boolean',
    ];

    public function memberships()
    {
        return $this->hasMany(BusinessMembership::class);
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_memberships')
            ->withPivot('role', 'is_owner', 'status', 'permissions')
            ->withTimestamps();
    }

    public function currentBusiness()
    {
        return $this->belongsTo(Business::class, 'current_business_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(UserActivityLog::class);
    }

    public function isOwnerOf(Business $business): bool
    {
        return $this->memberships()
            ->where('business_id', $business->id)
            ->where('is_owner', true)
            ->exists();
    }

    public function membershipFor(?int $businessId = null): ?BusinessMembership
    {
        $businessId = $businessId ?: $this->current_business_id;
        if (!$businessId) {
            return null;
        }

        return $this->memberships()->where('business_id', $businessId)->first();
    }

    public function roleInBusiness(?int $businessId = null): ?string
    {
        $membership = $this->membershipFor($businessId);
        return $membership ? $membership->role : null;
    }

    public function hasPermission(string $permissionSlug, ?int $businessId = null): bool
    {
        if ($this->is_super_admin) {
            return true;
        }

        $membership = $this->membershipFor($businessId);
        if (!$membership || $membership->status !== 'active') {
            return false;
        }

        if ($membership->is_owner || $membership->role === 'owner') {
            return true;
        }

        // Custom permission override on membership if specified
        if (!empty($membership->permissions) && is_array($membership->permissions)) {
            if (in_array($permissionSlug, $membership->permissions)) {
                return true;
            }
        }

        // Check assigned role permissions
        $role = Role::where('slug', $membership->role)->with('permissions')->first();
        if ($role && $role->permissions->contains('slug', $permissionSlug)) {
            return true;
        }

        return false;
    }
}
