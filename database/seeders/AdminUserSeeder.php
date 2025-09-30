<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'manage-settings',
            'manage-reservations',
            'manage-tables',
            'manage-menus', 
            'manage-users',
            'manage-reviews',
            'manage-gallery'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create admin role dengan semua permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        // Cek apakah user admin sudah ada
        $existingAdmin = User::where('email', 'admin@pitychick.com')->first();
        
        if ($existingAdmin) {
            // Assign role ke existing admin
            $existingAdmin->assignRole('admin');
            $this->command->info('Existing admin user assigned admin role!');
        } else {
            // Buat user admin baru
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@pitychick.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);

            // Assign admin role
            $admin->assignRole('admin');
            
            $this->command->info('Admin user created with admin role!');
        }

        $this->command->info('Email: admin@pitychick.com');
        $this->command->info('Password: password123');
        
        // Verifikasi
        $adminUser = User::where('email', 'admin@pitychick.com')->first();
        $this->command->table(
            ['ID', 'Name', 'Email', 'Role', 'Permissions'],
            [[
                $adminUser->id, 
                $adminUser->name, 
                $adminUser->email, 
                $adminUser->getRoleNames()->implode(', '),
                $adminUser->getAllPermissions()->pluck('name')->implode(', ')
            ]]
        );
    }
}