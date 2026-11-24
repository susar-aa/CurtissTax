<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Business;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBusinesses = Business::count();
        $activeTrials = Business::where('subscription_status', 'trial')
            ->where('trial_ends_at', '>', now())
            ->count();
        $activeSubscriptions = Business::where('subscription_status', 'active')->count();
        $expiredAccounts = Business::where('subscription_status', 'expired')
            ->orWhere(function ($q) {
                $q->where('subscription_status', 'trial')->where('trial_ends_at', '<=', now());
            })->count();

        // Recent businesses created with explicit columns
        $recentBusinesses = Business::leftJoin('users', 'businesses.created_by_user_id', '=', 'users.id')
            ->select([
                'businesses.id',
                'businesses.name',
                'businesses.tin',
                'businesses.vat_number',
                'businesses.status',
                'businesses.subscription_status',
                'businesses.trial_ends_at',
                'businesses.created_at',
                'users.name as owner_name',
                'users.email as owner_email',
            ])
            ->orderBy('businesses.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBusinesses',
            'activeTrials',
            'activeSubscriptions',
            'expiredAccounts',
            'recentBusinesses'
        ));
    }
}
