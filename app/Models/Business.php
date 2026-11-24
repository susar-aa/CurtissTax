<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'legal_name',
        'registration_number',
        'tin',
        'vat_number',
        'is_vat_registered',
        'phone',
        'email',
        'website',
        'address_line1',
        'address_line2',
        'city',
        'postal_code',
        'district',
        'province',
        'country',
        'currency',
        'logo_path',
        'vat_cert_path',
        'status',
        'trial_starts_at',
        'trial_ends_at',
        'subscription_status',
        'current_plan_id',
        'created_by_user_id',
    ];

    protected $casts = [
        'is_vat_registered' => 'boolean',
        'trial_starts_at' => 'datetime',
        'trial_ends_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($business) {
            if (empty($business->uuid)) {
                $business->uuid = (string) Str::uuid();
            }
            if (empty($business->currency)) {
                $business->currency = 'LKR';
            }
            if (empty($business->country)) {
                $business->country = 'LK';
            }
        });
    }

    public function settings()
    {
        return $this->hasOne(BusinessSetting::class);
    }

    public function memberships()
    {
        return $this->hasMany(BusinessMembership::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'business_memberships')
            ->withPivot('role', 'is_owner', 'status', 'permissions')
            ->withTimestamps();
    }

    public function owner()
    {
        return $this->hasOneThrough(
            User::class,
            BusinessMembership::class,
            'business_id', // Foreign key on BusinessMembership table...
            'id',          // Foreign key on User table...
            'id',          // Local key on Business table...
            'user_id'      // Local key on BusinessMembership table...
        )->where('business_memberships.is_owner', true);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(BusinessSubscription::class);
    }

    public function latestSubscription()
    {
        return $this->hasOne(BusinessSubscription::class)->latestOfMany();
    }

    public function syncSubscriptionState(): void
    {
        app(\App\Services\SubscriptionService::class)->syncState($this);
    }

    public function currentPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'current_plan_id');
    }

    public function invitations()
    {
        return $this->hasMany(BusinessInvitation::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function isTrialActive(): bool
    {
        if ($this->subscription_status !== 'trial') {
            return false;
        }

        if (!$this->trial_ends_at) {
            return false;
        }

        return Carbon::now()->lt($this->trial_ends_at);
    }

    public function isTrialExpired(): bool
    {
        if ($this->subscription_status === 'trial') {
            return $this->trial_ends_at ? Carbon::now()->gte($this->trial_ends_at) : true;
        }

        return $this->subscription_status === 'expired';
    }

    public function hasActiveSubscription(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->subscription_status === 'active') {
            return true;
        }

        return $this->isTrialActive();
    }

    public function canCreateFinancialDocuments(): bool
    {
        // Expired or suspended accounts have read-only access
        return $this->hasActiveSubscription();
    }

    public function daysRemainingInTrial(): int
    {
        if (!$this->isTrialActive() || !$this->trial_ends_at) {
            return 0;
        }

        return (int) ceil(Carbon::now()->floatDiffInDays($this->trial_ends_at, false));
    }
}
