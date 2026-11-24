<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $business = app('current_business');

        if (!auth()->user()->hasPermission('audit.view', $business->id)) {
            abort(403, __('app.unauthorized_permission'));
        }

        $query = AuditLog::leftJoin('users', 'audit_logs.user_id', '=', 'users.id')
            ->where('audit_logs.business_id', $business->id)
            ->select([
                'audit_logs.id',
                'audit_logs.event',
                'audit_logs.auditable_type',
                'audit_logs.auditable_id',
                'audit_logs.old_values',
                'audit_logs.new_values',
                'audit_logs.ip_address',
                'audit_logs.created_at',
                'users.name as user_name',
                'users.email as user_email',
            ]);

        if ($request->filled('event')) {
            $query->where('audit_logs.event', $request->query('event'));
        }

        $logs = $query->orderBy('audit_logs.created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('app.audit-logs', compact('business', 'logs'));
    }
}
