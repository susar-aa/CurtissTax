<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Business;
use App\Models\BusinessMembership;
use App\Models\BusinessSetting;
use App\Models\BusinessSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BusinessRegistrationService
{
    /**
     * Complete business and owner registration with 14-day free trial.
     * Guaranteed atomic via DB transaction.
     */
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $normalizedEmail = strtolower(trim($data['email']));

            // Enforce One Business Per Account requirement
            $existingUser = User::where('email', $normalizedEmail)->first();
            if ($existingUser) {
                $alreadyOwns = BusinessMembership::where('user_id', $existingUser->id)
                    ->where('is_owner', true)
                    ->exists();

                if ($alreadyOwns) {
                    throw new \Exception(__('app.already_owns_business'));
                }
            }

            // 1. Create User
            $user = User::create([
                'name' => $data['name'],
                'email' => $normalizedEmail,
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'status' => 'active',
                'locale' => $data['locale'] ?? 'en',
                'is_super_admin' => false,
            ]);

            // 2. Calculate 14-day trial period
            $trialStartsAt = Carbon::now();
            $trialEndsAt = Carbon::now()->addDays(14);

            $freePlan = SubscriptionPlan::where('slug', 'free-trial')->first();

            // 3. Create Business
            $business = Business::create([
                'uuid' => (string) Str::uuid(),
                'name' => $data['business_name'],
                'legal_name' => $data['legal_name'] ?? $data['business_name'],
                'registration_number' => $data['registration_number'] ?? null,
                'tin' => $data['tin'] ?? null,
                'vat_number' => $data['vat_number'] ?? null,
                'is_vat_registered' => !empty($data['is_vat_registered']),
                'phone' => $data['business_phone'] ?? ($data['phone'] ?? null),
                'email' => $data['business_email'] ?? $user->email,
                'address_line1' => $data['address_line1'] ?? null,
                'address_line2' => $data['address_line2'] ?? null,
                'city' => $data['city'] ?? null,
                'district' => $data['district'] ?? null,
                'province' => $data['province'] ?? null,
                'country' => 'LK',
                'currency' => 'LKR',
                'status' => 'active',
                'trial_starts_at' => $trialStartsAt,
                'trial_ends_at' => $trialEndsAt,
                'subscription_status' => 'trial',
                'current_plan_id' => $freePlan ? $freePlan->id : null,
                'created_by_user_id' => $user->id,
            ]);

            // 4. Create Business Membership as Owner
            $membership = BusinessMembership::create([
                'business_id' => $business->id,
                'user_id' => $user->id,
                'role' => 'owner',
                'is_owner' => true,
                'status' => 'active',
            ]);

            // Set User's current business
            $user->update(['current_business_id' => $business->id]);

            // 5. Create default business settings
            $settings = BusinessSetting::create([
                'business_id' => $business->id,
                'financial_year_start_month' => 4, // April (Sri Lanka)
                'default_tax_rate' => 18.00,       // 18% VAT Sri Lanka
                'invoice_prefix' => 'INV-',
                'invoice_next_number' => 1001,
                'invoice_locale' => $data['invoice_locale'] ?? 'en',
                'invoice_footer_notes' => 'Thank you for your business. Subject to Sri Lanka Inland Revenue regulations.',
                'invoice_terms' => 'Payment due within 14 days of invoice date.',
                'show_bank_details' => false,
            ]);

            // 6. Record trial subscription record via authoritative SubscriptionService
            app(SubscriptionService::class)->createTrial($business);

            // 7. Audit log & activity log
            AuditLog::log('business_registered', $business, null, [
                'name' => $business->name,
                'trial_starts_at' => $trialStartsAt->toIso8601String(),
                'trial_ends_at' => $trialEndsAt->toIso8601String(),
            ], $business->id);

            UserActivityLog::record(
                'register',
                "Registered business '{$business->name}' with 14-day trial",
                $user->id,
                $business->id
            );

            return [
                'user' => $user,
                'business' => $business,
                'membership' => $membership,
                'settings' => $settings,
            ];
        });
    }
}
