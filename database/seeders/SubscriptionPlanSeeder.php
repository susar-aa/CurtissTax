<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'description' => '14-day full access trial for new businesses',
                'price_lkr_monthly' => 0.00,
                'price_lkr_annually' => 0.00,
                'max_users' => 2,
                'max_invoices_per_month' => 50,
                'max_branches' => 1,
                'features' => json_encode([
                    'vat_invoicing' => true,
                    'non_vat_invoicing' => true,
                    'trilingual_pdf' => true,
                    'reports' => true,
                    'audit_log' => true,
                ]),
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Ideal for sole proprietors and growing small businesses in Sri Lanka',
                'price_lkr_monthly' => 2500.00,
                'price_lkr_annually' => 25000.00,
                'max_users' => 2,
                'max_invoices_per_month' => 150,
                'max_branches' => 1,
                'features' => json_encode([
                    'vat_invoicing' => true,
                    'non_vat_invoicing' => true,
                    'trilingual_pdf' => true,
                    'reports' => true,
                    'audit_log' => true,
                    'email_support' => true,
                ]),
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For VAT-registered companies with active sales teams and branches',
                'price_lkr_monthly' => 5000.00,
                'price_lkr_annually' => 50000.00,
                'max_users' => 5,
                'max_invoices_per_month' => 1000,
                'max_branches' => 3,
                'features' => json_encode([
                    'vat_invoicing' => true,
                    'non_vat_invoicing' => true,
                    'trilingual_pdf' => true,
                    'reports' => true,
                    'audit_log' => true,
                    'multi_branch' => true,
                    'priority_support' => true,
                ]),
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Unlimited users and branches for large operations',
                'price_lkr_monthly' => 12500.00,
                'price_lkr_annually' => 125000.00,
                'max_users' => 25,
                'max_invoices_per_month' => 10000,
                'max_branches' => 10,
                'features' => json_encode([
                    'vat_invoicing' => true,
                    'non_vat_invoicing' => true,
                    'trilingual_pdf' => true,
                    'reports' => true,
                    'audit_log' => true,
                    'multi_branch' => true,
                    'custom_tax_rules' => true,
                    'dedicated_support' => true,
                ]),
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
