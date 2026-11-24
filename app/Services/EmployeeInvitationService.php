<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Business;
use App\Models\BusinessInvitation;
use App\Models\BusinessMembership;
use App\Models\User;
use App\Models\UserActivityLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeInvitationService
{
    /**
     * Create an employee invitation.
     */
    public function invite(Business $business, User $inviter, string $email, string $role): BusinessInvitation
    {
        $email = strtolower(trim($email));

        // Enforce Owner restriction: Ownership cannot be granted via employee invitation
        if ($role === 'owner') {
            throw new Exception(__('app.cannot_invite_as_owner'));
        }

        // 1. Verify user limit on current subscription plan
        $plan = $business->currentPlan;
        if ($plan && $plan->max_users > 0) {
            $currentUsersCount = $business->memberships()->where('status', 'active')->count();
            if ($currentUsersCount >= $plan->max_users) {
                throw new Exception(__('app.plan_user_limit_reached', ['max' => $plan->max_users]));
            }
        }

        // 2. Check if user is already an active member of this business or owns another business
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $isAlreadyMember = BusinessMembership::where('business_id', $business->id)
                ->where('user_id', $existingUser->id)
                ->where('status', 'active')
                ->exists();

            if ($isAlreadyMember) {
                throw new Exception(__('app.user_already_member'));
            }

            $alreadyOwnsOther = BusinessMembership::where('user_id', $existingUser->id)
                ->where('is_owner', true)
                ->exists();

            if ($alreadyOwnsOther) {
                throw new Exception(__('app.user_already_owns_other_business'));
            }
        }

        // 3. Invalidate previous pending invitations for this email in this business
        BusinessInvitation::where('business_id', $business->id)
            ->where('email', $email)
            ->whereNull('accepted_at')
            ->delete();

        // 4. Create new invitation with 7-day expiry
        $invitation = BusinessInvitation::create([
            'business_id' => $business->id,
            'email' => $email,
            'role' => $role,
            'token' => Str::random(64),
            'invited_by_user_id' => $inviter->id,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        AuditLog::log('invitation_created', $invitation, null, [
            'email' => $email,
            'role' => $role,
        ], $business->id);

        UserActivityLog::record(
            'team_invite',
            "Invited {$email} with role '{$role}'",
            $inviter->id,
            $business->id
        );

        return $invitation;
    }

    /**
     * Accept invitation.
     */
    public function accept(string $token, array $userData): array
    {
        $invitation = BusinessInvitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        if ($invitation->isExpired()) {
            throw new Exception(__('app.invitation_expired'));
        }

        return DB::transaction(function () use ($invitation, $userData) {
            // Find or create the user
            $user = User::where('email', $invitation->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $invitation->email,
                    'password' => Hash::make($userData['password']),
                    'status' => 'active',
                    'locale' => $userData['locale'] ?? 'en',
                    'current_business_id' => $invitation->business_id,
                ]);
            } else {
                $alreadyOwnsOther = BusinessMembership::where('user_id', $user->id)
                    ->where('is_owner', true)
                    ->exists();

                if ($alreadyOwnsOther) {
                    throw new Exception(__('app.user_already_owns_other_business'));
                }

                if (empty($user->current_business_id)) {
                    $user->update(['current_business_id' => $invitation->business_id]);
                }
            }

            // Create or update membership
            $membership = BusinessMembership::updateOrCreate(
                [
                    'business_id' => $invitation->business_id,
                    'user_id' => $user->id,
                ],
                [
                    'role' => $invitation->role,
                    'is_owner' => false,
                    'status' => 'active',
                ]
            );

            // Mark invitation accepted
            $invitation->update(['accepted_at' => Carbon::now()]);

            AuditLog::log('invitation_accepted', $membership, null, [
                'user_id' => $user->id,
                'role' => $invitation->role,
            ], $invitation->business_id);

            UserActivityLog::record(
                'team_joined',
                "Joined business as '{$invitation->role}'",
                $user->id,
                $invitation->business_id
            );

            return [
                'user' => $user,
                'membership' => $membership,
                'invitation' => $invitation,
            ];
        });
    }
}
