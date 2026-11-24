<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'plan_id',
        'billing_cycle',
        'status',
        'starts_at',
        'ends_at',
        'trial_ends_at',
        'canceled_at',
        'amount_paid',
        'payment_method',
        'reference_note',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'canceled_at' => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }
}
