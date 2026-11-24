<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Business;
use App\Models\BusinessMembership;
use App\Models\User;
use App\Services\BusinessRegistrationService;
use App\Services\EmployeeInvitationService;
use Tests\TestCase;

class SecurityHardeningAndPermissionsTest extends TestCase
{
    public function test_staff_member_cannot_modify_business_settings()
    {
        $regService = app(BusinessRegistrationService::class);
        $inviteService = app(EmployeeInvitationService::class);

        $res = $regService->register([
            'name' => 'Owner Admin',
            'email' => 'owner.perm.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Security Test Ltd',
        ]);

        $owner = $res['user'];
        $business = $res['business'];

        // Invite and register a staff member
        $staffEmail = 'staff.member.' . time() . '@test.lk';
        $invitation = $inviteService->invite($business, $owner, $staffEmail, 'staff');

        $acceptResult = $inviteService->accept($invitation->token, [
            'name' => 'Junior Staff',
            'password' => 'StaffPass123!',
        ]);

        $staffUser = $acceptResult['user'];

        // Staff user attempts to POST update settings -> 403 Forbidden
        $response = $this->actingAs($staffUser)->post('/app/settings', [
            'name' => 'Hacked Company Name',
            'financial_year_start_month' => 4,
            'default_tax_rate' => 0,
            'invoice_prefix' => 'HACK-',
            'invoice_locale' => 'en',
        ]);

        $response->assertStatus(403);
    }

    public function test_staff_member_cannot_invite_team_members()
    {
        $regService = app(BusinessRegistrationService::class);
        $inviteService = app(EmployeeInvitationService::class);

        $res = $regService->register([
            'name' => 'Owner Admin',
            'email' => 'owner.inviteperm.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Invite Perm Ltd',
        ]);

        $owner = $res['user'];
        $business = $res['business'];

        // Staff member
        $staffEmail = 'staff.inviter.' . time() . '@test.lk';
        $invitation = $inviteService->invite($business, $owner, $staffEmail, 'staff');

        $acceptResult = $inviteService->accept($invitation->token, [
            'name' => 'Junior Staff',
            'password' => 'StaffPass123!',
        ]);

        $staffUser = $acceptResult['user'];

        // Staff user attempts to invite another person -> 403 Forbidden
        $response = $this->actingAs($staffUser)->post('/app/team/invite', [
            'email' => 'thirdparty@test.lk',
            'role' => 'admin',
        ]);

        $response->assertStatus(403);
    }

    public function test_staff_member_cannot_view_audit_logs()
    {
        $regService = app(BusinessRegistrationService::class);
        $inviteService = app(EmployeeInvitationService::class);

        $res = $regService->register([
            'name' => 'Owner Admin',
            'email' => 'owner.auditperm.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Audit Perm Ltd',
        ]);

        $owner = $res['user'];
        $business = $res['business'];

        $staffEmail = 'staff.audit.' . time() . '@test.lk';
        $invitation = $inviteService->invite($business, $owner, $staffEmail, 'staff');

        $acceptResult = $inviteService->accept($invitation->token, [
            'name' => 'Junior Staff',
            'password' => 'StaffPass123!',
        ]);

        $staffUser = $acceptResult['user'];

        // Staff user attempts to view audit logs -> 403 Forbidden
        $response = $this->actingAs($staffUser)->get('/app/audit-logs');
        $response->assertStatus(403);
    }

    public function test_audit_logs_query_isolation_between_tenants()
    {
        $regService = app(BusinessRegistrationService::class);

        $resA = $regService->register([
            'name' => 'Owner Alpha',
            'email' => 'alpha.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Alpha Audit Co',
        ]);

        $resB = $regService->register([
            'name' => 'Owner Beta',
            'email' => 'beta.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Beta Audit Co',
        ]);

        // When Owner Alpha queries audit logs, Beta's logs are completely invisible
        $responseA = $this->actingAs($resA['user'])->get('/app/audit-logs');
        $responseA->assertStatus(200);
        $responseA->assertSee('Alpha Audit Co');
        $responseA->assertDontSee('Beta Audit Co');
    }
}
