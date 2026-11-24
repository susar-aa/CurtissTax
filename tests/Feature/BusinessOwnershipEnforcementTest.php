<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\BusinessMembership;
use App\Models\User;
use App\Services\BusinessRegistrationService;
use App\Services\EmployeeInvitationService;
use Exception;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class BusinessOwnershipEnforcementTest extends TestCase
{
    public function test_account_cannot_own_multiple_businesses()
    {
        $regService = app(BusinessRegistrationService::class);

        // 1. Register first business
        $resA = $regService->register([
            'name' => 'Single Owner',
            'email' => 'single.owner.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'First Business Entity (Pvt) Ltd',
        ]);

        $user = $resA['user'];
        $this->assertTrue($user->isOwnerOf($resA['business']));

        // 2. Attempt to register a second business with the same email
        $this->expectException(Exception::class);
        $regService->register([
            'name' => 'Single Owner',
            'email' => $user->email,
            'password' => 'Password123!',
            'business_name' => 'Second Business Entity Attempt',
        ]);
    }

    public function test_database_level_constraint_prevents_duplicate_ownership()
    {
        $user = User::create([
            'name' => 'Database Constraint Test User',
            'email' => 'db.test.' . time() . '@test.lk',
            'password' => bcrypt('Password123!'),
        ]);

        $biz1 = Business::create(['name' => 'Business One', 'tin' => '111']);
        $biz2 = Business::create(['name' => 'Business Two', 'tin' => '222']);

        // First ownership should succeed
        BusinessMembership::create([
            'business_id' => $biz1->id,
            'user_id' => $user->id,
            'role' => 'owner',
            'is_owner' => true,
        ]);

        // Second ownership on different business must trigger DB unique constraint violation
        $this->expectException(QueryException::class);
        BusinessMembership::create([
            'business_id' => $biz2->id,
            'user_id' => $user->id,
            'role' => 'owner',
            'is_owner' => true,
        ]);
    }

    public function test_employee_cannot_be_invited_as_owner()
    {
        $regService = app(BusinessRegistrationService::class);
        $inviteService = app(EmployeeInvitationService::class);

        $res = $regService->register([
            'name' => 'Inviting Owner',
            'email' => 'inviter.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Corporate Entity',
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('app.cannot_invite_as_owner'));

        $inviteService->invite($res['business'], $res['user'], 'newperson@test.lk', 'owner');
    }

    public function test_existing_business_owner_cannot_be_invited_to_another_business()
    {
        $regService = app(BusinessRegistrationService::class);
        $inviteService = app(EmployeeInvitationService::class);

        // Owner 1
        $res1 = $regService->register([
            'name' => 'Independent Owner 1',
            'email' => 'indep1.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Enterprise 1',
        ]);

        // Owner 2
        $res2 = $regService->register([
            'name' => 'Independent Owner 2',
            'email' => 'indep2.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Enterprise 2',
        ]);

        // Owner 1 attempts to invite Owner 2 into Enterprise 1
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('app.user_already_owns_other_business'));

        $inviteService->invite($res1['business'], $res1['user'], $res2['user']->email, 'staff');
    }
}
