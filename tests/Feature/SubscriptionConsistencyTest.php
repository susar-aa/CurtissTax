<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\BusinessSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\BusinessRegistrationService;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Tests\TestCase;

class SubscriptionConsistencyTest extends TestCase
{
    public function test_subscription_service_manages_authoritative_lifecycle()
    {
        $regService = app(BusinessRegistrationService::class);
        $subService = app(SubscriptionService::class);

        $res = $regService->register([
            'name' => 'Sub Owner',
            'email' => 'sub.lifecycle.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Sub Test Co',
        ]);

        $business = $res['business'];

        // 1. Initial State: 14-day trial
        $this->assertEquals('trial', $business->subscription_status);
        $this->assertTrue($business->isTrialActive());
        $this->assertFalse($business->isTrialExpired());

        // 2. Activate Paid Plan
        $starterPlan = SubscriptionPlan::where('slug', 'starter')->first();
        $this->assertNotNull($starterPlan);

        $sub = $subService->activatePlan(
            $business,
            $starterPlan,
            'monthly',
            2500.00,
            'bank_transfer',
            'REF-12345'
        );

        $business->refresh();
        $this->assertEquals('active', $business->subscription_status);
        $this->assertEquals($starterPlan->id, $business->current_plan_id);
        $this->assertTrue($business->hasActiveSubscription());

        // 3. Expire Subscription
        $subService->expireSubscription($business);

        $business->refresh();
        $this->assertEquals('expired', $business->subscription_status);
        $this->assertFalse($business->hasActiveSubscription());
        $this->assertTrue($business->isTrialExpired());
    }

    public function test_expired_subscription_blocks_state_changes_on_http_routes()
    {
        $regService = app(BusinessRegistrationService::class);
        $subService = app(SubscriptionService::class);

        $res = $regService->register([
            'name' => 'Expired Owner',
            'email' => 'expired.http.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Expired HTTP Test Co',
        ]);

        $user = $res['user'];
        $business = $res['business'];

        // Expire subscription
        $subService->expireSubscription($business);

        // GET request is allowed (Read-Only)
        $this->actingAs($user);
        $responseGet = $this->get('/app/dashboard');
        $responseGet->assertStatus(200);

        // POST request to update settings is blocked with redirect and error message
        $responsePost = $this->post('/app/settings', [
            'name' => 'Modified Name',
            'financial_year_start_month' => 4,
            'default_tax_rate' => 18,
            'invoice_prefix' => 'INV-',
            'invoice_locale' => 'en',
        ]);

        $responsePost->assertRedirect(route('app.subscription.index'));
        $responsePost->assertSessionHas('error');
    }
}
