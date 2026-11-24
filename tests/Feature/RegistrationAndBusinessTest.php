<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\BusinessMembership;
use App\Models\BusinessSetting;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\BusinessRegistrationService;
use Carbon\Carbon;
use Tests\TestCase;

class RegistrationAndBusinessTest extends TestCase
{
    public function test_user_registration_creates_business_and_starts_14_day_trial()
    {
        $service = app(BusinessRegistrationService::class);

        $data = [
            'name' => 'Kavinda Jayasuriya',
            'email' => 'kavinda.' . time() . '@testbusiness.lk',
            'phone' => '+94 71 999 8888',
            'password' => 'SecurePass123!',
            'business_name' => 'Lanka Cloud Technologies',
            'tin' => '998877665',
            'vat_number' => '998877665-7000',
            'is_vat_registered' => true,
            'city' => 'Kandy',
            'district' => 'Kandy',
            'invoice_locale' => 'en',
        ];

        $result = $service->register($data);

        // 1. Verify User
        $this->assertInstanceOf(User::class, $result['user']);
        $this->assertEquals($data['email'], $result['user']->email);
        $this->assertEquals('active', $result['user']->status);

        // 2. Verify Business
        $this->assertInstanceOf(Business::class, $result['business']);
        $this->assertEquals('Lanka Cloud Technologies', $result['business']->name);
        $this->assertEquals('LKR', $result['business']->currency);
        $this->assertEquals('LK', $result['business']->country);
        $this->assertTrue($result['business']->is_vat_registered);
        $this->assertNotEmpty($result['business']->uuid);

        // 3. Verify Business Ownership
        $this->assertInstanceOf(BusinessMembership::class, $result['membership']);
        $this->assertTrue($result['membership']->is_owner);
        $this->assertEquals('owner', $result['membership']->role);
        $this->assertEquals($result['user']->id, $result['membership']->user_id);
        $this->assertEquals($result['business']->id, $result['user']->current_business_id);

        // 4. Verify 14-Day Free Trial Calculation
        $this->assertEquals('trial', $result['business']->subscription_status);
        $this->assertNotNull($result['business']->trial_starts_at);
        $this->assertNotNull($result['business']->trial_ends_at);

        $diffInDays = round($result['business']->trial_starts_at->floatDiffInDays($result['business']->trial_ends_at));
        $this->assertEquals(14, $diffInDays);
        $this->assertTrue($result['business']->isTrialActive());
        $this->assertFalse($result['business']->isTrialExpired());
        $this->assertEquals(14, $result['business']->daysRemainingInTrial());

        // 5. Verify Settings
        $this->assertInstanceOf(BusinessSetting::class, $result['settings']);
        $this->assertEquals('INV-', $result['settings']->invoice_prefix);
        $this->assertEquals(1001, $result['settings']->invoice_next_number);
        $this->assertEquals('en', $result['settings']->invoice_locale);
    }
}
