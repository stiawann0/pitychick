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

        // Create permissions
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
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions); // All permissions

        $customerRole = Role::create(['name' => 'customer']);
        $customerRole->givePermissionTo(['view dashboard']); // Limited permissions

        // Assign admin role to existing admin user
        $adminUser = \App\Models\User::where('email', 'admin@pitychick.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }

        // Assign customer role to existing customer users
        $customerUsers = \App\Models\User::where('email', '!=', 'customer@pitychick.com')->get();
        foreach ($customerUsers as $user) {
            $user->assignRole('customer');
        }
    }
}