<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $admin = Role::create(['name' => 'admin']);
        $superAdmin = Role::create(['name' => 'super-admin']);
        $user = Role::create(['name' => 'user']);

        // Define Permissions
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'asset-list',
            'asset-create',
            'asset-edit',
            'asset-delete',
            'enquiry-list',
            'enquiry-edit',
            'enquiry-delete',
            'dashboard-view',
            'campaign-list',
            'campaign-create',
            'campaign-edit',
            'campaign-delete',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign Permissions to Roles
        $admin->syncPermissions($permissions); // Admin gets all permissions

        $superAdminPermissions = [
            'role-list',
            'role-create',
            'role-edit',
            'permission-list',
            'permission-create',
            'permission-edit',
            'user-list',
            'user-create',
            'user-edit',
            'event-list',
            'event-create',
            'event-edit',
            'asset-list',
            'asset-create',
            'asset-edit',
            'campaign-list',
            'campaign-create',
            'campaign-edit',
        ];
        $superAdmin->syncPermissions($superAdminPermissions); // No delete permissions
        $userpermissions = [
            'enquiry-create',
        ];

        // Create Permissions
        foreach ($userpermissions as $userpermission) {
            Permission::firstOrCreate(['name' => $userpermission]);
        }

        // Assign Permissions to Roles
        $user->syncPermissions($userpermissions); // Admin gets all permissions


    }
}
