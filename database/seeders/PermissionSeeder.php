<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions only if they don't exist
        $permissions = [
            'view dashboard',
            'manage reservations', 
            'manage tables',
            'manage menus',
            'manage users',
            'manage settings',
            'manage home settings',
            'manage about settings',
            'manage gallery',
            'manage reviews',
            'manage footer',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles only if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign all permissions to admin role
        $adminRole->syncPermissions($permissions);

        // Assign limited permissions to customer role
        $customerRole->syncPermissions(['view dashboard']);

        // Assign admin role to existing admin user
        $adminUser = \App\Models\User::where('email', 'admin@pitychick.com')->first();
        if ($adminUser && !$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
        }

        // Assign customer role to existing customer users
        $customerUsers = \App\Models\User::where('email', '!=', 'admin@pitychick.com')->get();
        foreach ($customerUsers as $user) {
            if (!$user->hasRole('customer')) {
                $user->assignRole('customer');
            }
        }
    }
}