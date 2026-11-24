<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessMembership;
use App\Models\BusinessSetting;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            SubscriptionPlanSeeder::class,
        ]);

        // 1. Create CurtissTax Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@curtisstax.com'],
            [
                'name' => 'CurtissTax Admin',
                'password' => Hash::make('Admin@123456'),
                'is_super_admin' => true,
                'status' => 'active',
                'locale' => 'en',
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Demo Business User
        $demoUser = User::updateOrCreate(
            ['email' => 'demo@curtisstax.com'],
            [
                'name' => 'Sunil Perera',
                'phone' => '+94 77 123 4567',
                'password' => Hash::make('Demo@123456'),
                'is_super_admin' => false,
                'status' => 'active',
                'locale' => 'en',
                'email_verified_at' => now(),
            ]
        );

        $freeTrialPlan = SubscriptionPlan::where('slug', 'free-trial')->first();

        // 3. Create Demo Business with 14-day trial
        $trialStart = Carbon::now();
        $trialEnd = Carbon::now()->addDays(14);

        $demoBusiness = Business::updateOrCreate(
            ['tin' => '102938475'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Lanka Retail Traders',
                'legal_name' => 'Lanka Retail Traders (Pvt) Ltd',
                'registration_number' => 'PV00293841',
                'vat_number' => '102938475-7000',
                'is_vat_registered' => true,
                'phone' => '+94 11 234 5678',
                'email' => 'billing@lankaretail.lk',
                'address_line1' => 'No 45, Galle Road',
                'city' => 'Colombo 03',
                'district' => 'Colombo',
                'province' => 'Western Province',
                'country' => 'LK',
                'currency' => 'LKR',
                'status' => 'active',
                'trial_starts_at' => $trialStart,
                'trial_ends_at' => $trialEnd,
                'subscription_status' => 'trial',
                'current_plan_id' => $freeTrialPlan ? $freeTrialPlan->id : null,
                'created_by_user_id' => $demoUser->id,
            ]
        );

        // 4. Link User to Business as Owner
        BusinessMembership::updateOrCreate(
            ['business_id' => $demoBusiness->id, 'user_id' => $demoUser->id],
            [
                'role' => 'owner',
                'is_owner' => true,
                'status' => 'active',
            ]
        );

        // Set user's current business
        $demoUser->update(['current_business_id' => $demoBusiness->id]);

        // 5. Create default business settings
        BusinessSetting::updateOrCreate(
            ['business_id' => $demoBusiness->id],
            [
                'financial_year_start_month' => 4,
                'default_tax_rate' => 18.00,
                'invoice_prefix' => 'CTX-',
                'invoice_next_number' => 1001,
                'invoice_locale' => 'en',
                'invoice_footer_notes' => 'Thank you for your business. Subject to Sri Lanka Inland Revenue regulations.',
                'invoice_terms' => 'Payment due within 14 days of issue.',
                'show_bank_details' => true,
                'bank_name' => 'Commercial Bank of Ceylon',
                'bank_branch' => 'Kollupitiya',
                'bank_account_name' => 'Lanka Retail Traders (Pvt) Ltd',
                'bank_account_number' => '8001234567',
                'bank_swift_code' => 'CCEYLKAX',
            ]
        );
    }
}
