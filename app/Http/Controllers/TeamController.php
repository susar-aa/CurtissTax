<?php

namespace App\Http\Controllers;

use App\Models\BusinessInvitation;
use App\Models\BusinessMembership;
use App\Models\User;
use App\Services\EmployeeInvitationService;
use Exception;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $business = app('current_business');

        if (!auth()->user()->hasPermission('team.view', $business->id)) {
            abort(403, __('app.unauthorized_permission'));
        }

        // Explicit JOIN to fetch team members avoiding N+1 queries
        $members = BusinessMembership::join('users', 'business_memberships.user_id', '=', 'users.id')
            ->where('business_memberships.business_id', $business->id)
            ->select([
                'business_memberships.id as membership_id',
                'business_memberships.role',
                'business_memberships.is_owner',
                'business_memberships.status as membership_status',
                'business_memberships.created_at as joined_at',
                'users.id as user_id',
                'users.name',
                'users.email',
                'users.phone',
                'users.locale',
            ])
            ->orderBy('business_memberships.is_owner', 'desc')
            ->orderBy('users.name', 'asc')
            ->paginate(15);

        // Pending invitations for this business
        $pendingInvitations = BusinessInvitation::join('users', 'business_invitations.invited_by_user_id', '=', 'users.id')
            ->where('business_invitations.business_id', $business->id)
            ->whereNull('business_invitations.accepted_at')
            ->where('business_invitations.expires_at', '>', now())
            ->select([
                'business_invitations.id',
                'business_invitations.email',
                'business_invitations.role',
                'business_invitations.token',
                'business_invitations.expires_at',
                'business_invitations.created_at',
                'users.name as inviter_name',
            ])
            ->get();

        return view('app.team', compact('business', 'members', 'pendingInvitations'));
    }

    public function invite(Request $request, EmployeeInvitationService $invitationService)
    {
        $business = app('current_business');
        $user = auth()->user();

        if (!$user->hasPermission('team.invite', $business->id)) {
            abort(403, __('app.unauthorized_permission'));
        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'role' => ['required', 'in:admin,accountant,staff'],
        ]);

        try {
            $invitation = $invitationService->invite($business, $user, $validated['email'], $validated['role']);
            return redirect()->route('app.team.index')
                ->with('success', "Invitation sent successfully to {$invitation->email}");
        } catch (Exception $e) {
            return redirect()->route('app.team.index')
                ->with('error', $e->getMessage());
        }
    }
}
