<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Business;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $business = app('current_business');

        // Recent audit trails for this business using explicit column selection and pagination/limit
        $recentAudits = AuditLog::where('business_id', $business->id)
            ->join('users', 'audit_logs.user_id', '=', 'users.id')
            ->select([
                'audit_logs.id',
                'audit_logs.event',
                'audit_logs.auditable_type',
                'audit_logs.created_at',
                'users.name as user_name',
            ])
            ->orderBy('audit_logs.created_at', 'desc')
            ->limit(5)
            ->get();

        $activeTeamCount = $business->memberships()->where('status', 'active')->count();

        return view('app.dashboard', compact('business', 'recentAudits', 'activeTeamCount'));
    }
}
