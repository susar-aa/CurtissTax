<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantScopeMiddleware
{
    /**
     * Handle an incoming request.
     * Enforces strict multi-tenant isolation.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Super admins have global access to admin area, but in business app must have an active business
        if ($user->is_super_admin && !$user->current_business_id) {
            // If superadmin is accessing /admin, let them proceed
            if ($request->is('admin*')) {
                return $next($request);
            }
        }

        $businessId = $user->current_business_id;

        if (!$businessId) {
            // Check if user has any active business membership
            $membership = $user->memberships()->where('status', 'active')->first();
            if ($membership) {
                $user->update(['current_business_id' => $membership->business_id]);
                $businessId = $membership->business_id;
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', __('auth.no_active_business'));
            }
        }

        // Verify that the user is genuinely an authorized active member of this business
        $isMember = $user->memberships()
            ->where('business_id', $businessId)
            ->where('status', 'active')
            ->exists();

        if (!$isMember && !$user->is_super_admin) {
            abort(403, __('app.unauthorized_tenant_access'));
        }

        $business = $user->currentBusiness;

        if (!$business || $business->status === 'suspended') {
            abort(403, __('app.business_suspended'));
        }

        // Bind active tenant context into Laravel service container
        app()->instance('current_business_id', $business->id);
        app()->instance('current_business', $business);

        // Share with all Blade views
        view()->share('currentBusiness', $business);
        view()->share('currentUserMembership', $user->membershipFor($business->id));

        return $next($request);
    }
}
