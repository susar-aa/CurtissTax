<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\BusinessRegistrationService;
use Carbon\Carbon;
use Tests\TestCase;

class TrialAndSubscriptionTest extends TestCase
{
    public function test_trial_active_and_expiry_calculation()
    {
        $service = app(BusinessRegistrationService::class);

        $res = $service->register([
            'name' => 'Owner Trial',
            'email' => 'trial.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Trial Test Business',
        ]);

        $business = $res['business'];

        // Freshly created: trial is active
        $this->assertTrue($business->isTrialActive());
        $this->assertFalse($business->isTrialExpired());
        $this->assertTrue($business->hasActiveSubscription());
        $this->assertTrue($business->canCreateFinancialDocuments());

        // Fast forward 15 days (expired)
        $business->update([
            'trial_starts_at' => Carbon::now()->subDays(15),
            'trial_ends_at' => Carbon::now()->subDay(),
            'subscription_status' => 'expired',
        ]);

        $business->refresh();
        $this->assertFalse($business->isTrialActive());
        $this->assertTrue($business->isTrialExpired());
        $this->assertFalse($business->hasActiveSubscription());
        $this->assertFalse($business->canCreateFinancialDocuments());
    }

    public function test_expired_business_has_read_only_access_and_preserves_data()
    {
        $service = app(BusinessRegistrationService::class);

        $res = $service->register([
            'name' => 'Owner ReadOnly',
            'email' => 'readonly.' . time() . '@test.lk',
            'password' => 'Password123!',
            'business_name' => 'Preserved Business Data Ltd',
        ]);

        $user = $res['user'];
        $business = $res['business'];

        // Expire trial
        $business->update([
            'trial_starts_at' => Carbon::now()->subDays(20),
            'trial_ends_at' => Carbon::now()->subDays(6),
            'subscription_status' => 'expired',
        ]);

        // GET request to dashboard should succeed (Read-Only)
        $response = $this->actingAs($user)->get('/app/dashboard');
        $response->assertStatus(200);

        // GET request to settings should succeed (Read-Only)
        $responseSettings = $this->actingAs($user)->get('/app/settings');
        $responseSettings->assertStatus(200);

        // Business record remains in the database (never deleted on trial expiry)
        $this->assertDatabaseHas('businesses', [
            'id' => $business->id,
            'name' => 'Preserved Business Data Ltd',
        ]);
    }
}
