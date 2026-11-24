<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $business = app('current_business');

        if (!auth()->user()->hasPermission('subscription.view', $business->id)) {
            abort(403, __('app.unauthorized_permission'));
        }
        $currentPlan = $business->currentPlan;

        $availablePlans = SubscriptionPlan::where('is_active', true)
            ->where('slug', '!=', 'free-trial')
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'name', 'slug', 'description', 'price_lkr_monthly', 'price_lkr_annually', 'max_users', 'max_invoices_per_month', 'max_branches', 'features']);

        // Explicit JOIN to fetch past subscription history
        $history = $business->subscriptions()
            ->join('subscription_plans', 'business_subscriptions.plan_id', '=', 'subscription_plans.id')
            ->select([
                'business_subscriptions.id',
                'business_subscriptions.billing_cycle',
                'business_subscriptions.status',
                'business_subscriptions.starts_at',
                'business_subscriptions.ends_at',
                'business_subscriptions.amount_paid',
                'business_subscriptions.payment_method',
                'business_subscriptions.reference_note',
                'subscription_plans.name as plan_name',
            ])
            ->orderBy('business_subscriptions.starts_at', 'desc')
            ->get();

        return view('app.subscription', compact('business', 'currentPlan', 'availablePlans', 'history'));
    }
}
