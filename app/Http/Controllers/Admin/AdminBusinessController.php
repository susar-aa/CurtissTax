<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Business;
use Illuminate\Http\Request;

class AdminBusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::leftJoin('users', 'businesses.created_by_user_id', '=', 'users.id')
            ->leftJoin('subscription_plans', 'businesses.current_plan_id', '=', 'subscription_plans.id')
            ->select([
                'businesses.id',
                'businesses.uuid',
                'businesses.name',
                'businesses.tin',
                'businesses.vat_number',
                'businesses.is_vat_registered',
                'businesses.status',
                'businesses.subscription_status',
                'businesses.trial_starts_at',
                'businesses.trial_ends_at',
                'businesses.created_at',
                'users.name as owner_name',
                'users.email as owner_email',
                'subscription_plans.name as plan_name',
            ]);

        if ($request->filled('status')) {
            $query->where('businesses.status', $request->query('status'));
        }

        if ($request->filled('subscription')) {
            $query->where('businesses.subscription_status', $request->query('subscription'));
        }

        if ($request->filled('search')) {
            $term = $request->query('search');
            // Avoid leading wildcards where possible; trailing wildcard used
            $query->where('businesses.name', 'LIKE', $term . '%');
        }

        $businesses = $query->orderBy('businesses.created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.businesses.index', compact('businesses'));
    }

    public function toggleStatus(Business $business)
    {
        $oldStatus = $business->status;
        $newStatus = $oldStatus === 'active' ? 'suspended' : 'active';

        $business->update(['status' => $newStatus]);

        AuditLog::log('admin_business_status_toggled', $business, ['status' => $oldStatus], ['status' => $newStatus]);

        return redirect()->back()
            ->with('success', "Business {$business->name} status changed to {$newStatus}");
    }
}
