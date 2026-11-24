<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Business Management
            ['name' => 'View Business Profile', 'slug' => 'business.view', 'group' => 'business'],
            ['name' => 'Update Business Profile', 'slug' => 'business.update', 'group' => 'business'],
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'group' => 'business'],
            ['name' => 'Manage Branches', 'slug' => 'branches.manage', 'group' => 'business'],

            // Team Management
            ['name' => 'View Team Members', 'slug' => 'team.view', 'group' => 'team'],
            ['name' => 'Invite Team Members', 'slug' => 'team.invite', 'group' => 'team'],
            ['name' => 'Update Team Members', 'slug' => 'team.update', 'group' => 'team'],
            ['name' => 'Remove Team Members', 'slug' => 'team.remove', 'group' => 'team'],

            // Invoicing & Finance
            ['name' => 'View Invoices', 'slug' => 'invoices.view', 'group' => 'invoices'],
            ['name' => 'Create Invoices', 'slug' => 'invoices.create', 'group' => 'invoices'],
            ['name' => 'Update Invoices', 'slug' => 'invoices.update', 'group' => 'invoices'],
            ['name' => 'Cancel Invoices', 'slug' => 'invoices.cancel', 'group' => 'invoices'],

            // Subscriptions & Billing
            ['name' => 'View Subscription', 'slug' => 'subscription.view', 'group' => 'subscription'],
            ['name' => 'Manage Subscription', 'slug' => 'subscription.manage', 'group' => 'subscription'],

            // Logs & Audits
            ['name' => 'View Audit Logs', 'slug' => 'audit.view', 'group' => 'audit'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['slug' => $perm['slug']], $perm);
        }

        $roles = [
            [
                'name' => 'Owner',
                'slug' => 'owner',
                'description' => 'Full administrative control over business profile, subscription, and team',
                'permissions' => Permission::pluck('id')->toArray(),
            ],
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Can manage business team, settings, and day-to-day operations',
                'permissions' => Permission::where('group', '!=', 'subscription')->pluck('id')->toArray(),
            ],
            [
                'name' => 'Accountant',
                'slug' => 'accountant',
                'description' => 'Can create and manage invoices, view financial reports and audit logs',
                'permissions' => Permission::whereIn('group', ['invoices', 'audit'])->pluck('id')->toArray(),
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Can view and create draft invoices and view company profile',
                'permissions' => Permission::whereIn('slug', ['business.view', 'invoices.view', 'invoices.create'])->pluck('id')->toArray(),
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                ['name' => $roleData['name'], 'description' => $roleData['description'], 'is_system' => true]
            );

            if (!empty($roleData['permissions'])) {
                $role->permissions()->sync($roleData['permissions']);
            }
        }
    }
}
