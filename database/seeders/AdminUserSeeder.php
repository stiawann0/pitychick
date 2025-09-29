<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Hapus user admin yang sudah ada jika ada
        DB::table('users')->where('email', 'admin@pitychick.com')->delete();

        // Buat user admin baru
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@pitychick.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'role' => User::ROLE_ADMIN,
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@pitychick.com');
        $this->command->info('Password: password123');
        
        // Verifikasi data
        $this->command->table(
            ['ID', 'Name', 'Email', 'Role', 'Is Admin'],
            [[$admin->id, $admin->name, $admin->email, $admin->role, $admin->is_admin ? 'Yes' : 'No']]
        );
    }
}