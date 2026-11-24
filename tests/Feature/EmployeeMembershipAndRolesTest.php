<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\BusinessInvitation;
use App\Models\BusinessMembership;
use App\Models\User;
use App\Services\BusinessRegistrationService;
use App\Services\EmployeeInvitationService;
use Tests\TestCase;

class EmployeeMembershipAndRolesTest extends TestCase
{
    public function test_owner_can_invite_team_member()
    {
        $regService = app(BusinessRegistrationService::class);
        $inviteService = app(EmployeeInvitationService::class);

        $res = $regService->register([
            'name' => 'Team Owner',
            'email' => 'owner.team.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Team Test Business',
        ]);

        $owner = $res['user'];
        $business = $res['business'];

        $inviteeEmail = 'accountant.' . time() . '@test.lk';
        $invitation = $inviteService->invite($business, $owner, $inviteeEmail, 'accountant');

        $this->assertInstanceOf(BusinessInvitation::class, $invitation);
        $this->assertEquals($inviteeEmail, $invitation->email);
        $this->assertEquals('accountant', $invitation->role);
        $this->assertNotEmpty($invitation->token);
        $this->assertFalse($invitation->isExpired());
        $this->assertFalse($invitation->isAccepted());

        // Accept invitation
        $acceptResult = $inviteService->accept($invitation->token, [
            'name' => 'Saman Perera',
            'password' => 'AccountantPass123!',
            'locale' => 'si',
        ]);

        $this->assertInstanceOf(User::class, $acceptResult['user']);
        $this->assertEquals($inviteeEmail, $acceptResult['user']->email);
        $this->assertEquals('accountant', $acceptResult['membership']->role);
        $this->assertFalse($acceptResult['membership']->is_owner);

        // Check permissions
        $this->assertTrue($owner->hasPermission('business.update', $business->id));
        $this->assertTrue($owner->hasPermission('subscription.manage', $business->id));

        $newAccountant = $acceptResult['user'];
        $this->assertTrue($newAccountant->hasPermission('invoices.view', $business->id));
        $this->assertFalse($newAccountant->hasPermission('subscription.manage', $business->id));
    }
}
