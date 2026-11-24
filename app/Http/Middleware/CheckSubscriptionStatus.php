<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscriptionStatus
{
    /**
     * Enforces trial and subscription restrictions.
     * Expired accounts retain full read-only access to historical records,
     * but are restricted from creating or modifying financial documents.
     */
    public function handle(Request $request, Closure $next)
    {
        $business = app()->has('current_business') ? app('current_business') : null;

        if (!$business && auth()->check() && auth()->user()->currentBusiness) {
            $business = auth()->user()->currentBusiness;
        }

        if (!$business) {
            return $next($request);
        }

        // Check if subscription or trial has expired
        if ($business->isTrialExpired() && !$business->hasActiveSubscription()) {
            // Update business status if not yet marked expired
            if ($business->subscription_status !== 'expired') {
                $business->update(['subscription_status' => 'expired']);
            }

            // Read-only access allowed for GET/HEAD requests
            if ($request->isMethodSafe()) {
                view()->share('subscriptionExpiredNotice', true);
                return $next($request);
            }

            // If attempting a state-changing action, check if it's the subscription renewal/checkout flow
            if ($request->is('app/subscription*') || $request->is('app/profile*') || $request->is('logout')) {
                return $next($request);
            }

            // Block mutating financial actions with localized response
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => __('app.subscription_expired_title'),
                    'message' => __('app.subscription_expired_desc'),
                    'read_only' => true,
                ], 403);
            }

            return redirect()->route('app.subscription.index')
                ->with('error', __('app.subscription_expired_desc'));
        }

        return $next($request);
    }
}
