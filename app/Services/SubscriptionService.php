<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Business;
use App\Models\BusinessSubscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    /**
     * Create 14-day free trial subscription as authoritative record.
     */
    public function createTrial(Business $business): BusinessSubscription
    {
        $trialPlan = SubscriptionPlan::where('slug', 'free-trial')->first();
        $trialStartsAt = Carbon::now();
        $trialEndsAt = Carbon::now()->addDays(14);

        return DB::transaction(function () use ($business, $trialPlan, $trialStartsAt, $trialEndsAt) {
            $subscription = BusinessSubscription::create([
                'business_id' => $business->id,
                'plan_id' => $trialPlan ? $trialPlan->id : 1,
                'billing_cycle' => 'monthly',
                'status' => 'trial',
                'starts_at' => $trialStartsAt,
                'ends_at' => $trialEndsAt,
                'trial_ends_at' => $trialEndsAt,
                'amount_paid' => 0.00,
                'reference_note' => '14-Day Free Trial initiated upon business registration',
            ]);

            $this->syncState($business);

            return $subscription;
        });
    }

    /**
     * Activate paid subscription plan.
     */
    public function activatePlan(
        Business $business,
        SubscriptionPlan $plan,
        string $billingCycle,
        float $amount,
        ?string $paymentMethod = null,
        ?string $referenceNote = null
    ): BusinessSubscription {
        return DB::transaction(function () use ($business, $plan, $billingCycle, $amount, $paymentMethod, $referenceNote) {
            $startsAt = Carbon::now();
            $endsAt = $billingCycle === 'annually' ? Carbon::now()->addYear() : Carbon::now()->addMonth();

            // Mark previous active/trial subscriptions superseded
            BusinessSubscription::where('business_id', $business->id)
                ->whereIn('status', ['trial', 'active'])
                ->update(['status' => 'canceled', 'canceled_at' => Carbon::now()]);

            $newSubscription = BusinessSubscription::create([
                'business_id' => $business->id,
                'plan_id' => $plan->id,
                'billing_cycle' => $billingCycle,
                'status' => 'active',
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'trial_ends_at' => null,
                'amount_paid' => $amount,
                'payment_method' => $paymentMethod,
                'reference_note' => $referenceNote,
            ]);

            $this->syncState($business);

            AuditLog::log('subscription_activated', $business, null, [
                'plan' => $plan->name,
                'cycle' => $billingCycle,
                'amount' => $amount,
                'ends_at' => $endsAt->toIso8601String(),
            ], $business->id);

            return $newSubscription;
        });
    }

    /**
     * Explicitly expire business subscription/trial into read-only mode.
     */
    public function expireSubscription(Business $business): void
    {
        DB::transaction(function () use ($business) {
            BusinessSubscription::where('business_id', $business->id)
                ->whereIn('status', ['trial', 'active'])
                ->update(['status' => 'expired']);

            $this->syncState($business);

            AuditLog::log('subscription_expired', $business, null, [
                'reason' => 'Trial or billing period elapsed without renewal',
            ], $business->id);
        });
    }

    /**
     * Authoritatively synchronize business cached state from latest subscription record.
     */
    public function syncState(Business $business): void
    {
        $latest = BusinessSubscription::where('business_id', $business->id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$latest) {
            return;
        }

        $effectiveStatus = $latest->status;

        // Verify if active trial or subscription has passed its end date
        if ($effectiveStatus === 'trial') {
            if ($latest->trial_ends_at && Carbon::now()->gte($latest->trial_ends_at)) {
                $effectiveStatus = 'expired';
                $latest->update(['status' => 'expired']);
            }
        } elseif ($effectiveStatus === 'active') {
            if ($latest->ends_at && Carbon::now()->gte($latest->ends_at)) {
                $effectiveStatus = 'expired';
                $latest->update(['status' => 'expired']);
            }
        }

        $business->update([
            'subscription_status' => $effectiveStatus,
            'current_plan_id' => $latest->plan_id,
            'trial_starts_at' => $latest->starts_at,
            'trial_ends_at' => $latest->trial_ends_at,
        ]);
    }

    /**
     * Synchronize all expired trials across the platform.
     */
    public function syncAllExpired(): int
    {
        $expiredSubscriptions = BusinessSubscription::where('status', 'trial')
            ->where('trial_ends_at', '<=', Carbon::now())
            ->get();

        $count = 0;
        foreach ($expiredSubscriptions as $sub) {
            $sub->update(['status' => 'expired']);
            if ($sub->business) {
                $sub->business->update(['subscription_status' => 'expired']);
            }
            $count++;
        }

        return $count;
    }
}
