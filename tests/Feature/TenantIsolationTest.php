<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Business;
use App\Models\BusinessMembership;
use App\Models\User;
use App\Services\BusinessRegistrationService;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    public function test_tenant_scope_isolates_records_between_businesses()
    {
        $service = app(BusinessRegistrationService::class);

        // Business A
        $resA = $service->register([
            'name' => 'Owner A',
            'email' => 'owner.a.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Business Alpha (Pvt) Ltd',
        ]);
        $userA = $resA['user'];
        $bizA = $resA['business'];

        // Business B
        $resB = $service->register([
            'name' => 'Owner B',
            'email' => 'owner.b.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Business Beta (Pvt) Ltd',
        ]);
        $userB = $resB['user'];
        $bizB = $resB['business'];

        // Create branches for each
        Branch::create([
            'business_id' => $bizA->id,
            'name' => 'Alpha Colombo Branch',
            'is_main' => true,
        ]);

        Branch::create([
            'business_id' => $bizB->id,
            'name' => 'Beta Kandy Branch',
            'is_main' => true,
        ]);

        // When acting as User A, only Business A branches should be returned
        $this->actingAs($userA);
        app()->instance('current_business_id', $bizA->id);

        $branchesSeenByA = Branch::all();
        $this->assertTrue($branchesSeenByA->contains('name', 'Alpha Colombo Branch'));
        $this->assertFalse($branchesSeenByA->contains('name', 'Beta Kandy Branch'));

        // When acting as User B, only Business B branches should be returned
        $this->actingAs($userB);
        app()->instance('current_business_id', $bizB->id);

        $branchesSeenByB = Branch::all();
        $this->assertTrue($branchesSeenByB->contains('name', 'Beta Kandy Branch'));
        $this->assertFalse($branchesSeenByB->contains('name', 'Alpha Colombo Branch'));
    }

    public function test_tenant_middleware_blocks_access_to_unauthorized_business()
    {
        $service = app(BusinessRegistrationService::class);

        $resA = $service->register([
            'name' => 'User X',
            'email' => 'user.x.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Entity X',
        ]);

        $resB = $service->register([
            'name' => 'User Y',
            'email' => 'user.y.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Entity Y',
        ]);

        // Attempting to access app while current_business_id points to another business
        $userX = $resA['user'];
        $bizY = $resB['business'];

        $userX->update(['current_business_id' => $bizY->id]);

        $response = $this->actingAs($userX)->get('/app/dashboard');
        $response->assertStatus(403);
    }

    public function test_non_superadmin_cannot_access_superadmin_area()
    {
        $user = User::where('email', 'demo@curtisstax.com')->first();
        $this->assertFalse((bool)$user->is_super_admin);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }
}
