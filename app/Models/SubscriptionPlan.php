<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_lkr_monthly',
        'price_lkr_annually',
        'max_users',
        'max_invoices_per_month',
        'max_branches',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_lkr_monthly' => 'decimal:2',
        'price_lkr_annually' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'max_users' => 'integer',
        'max_invoices_per_month' => 'integer',
        'max_branches' => 'integer',
        'sort_order' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(BusinessSubscription::class, 'plan_id');
    }
}
