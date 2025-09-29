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
        // Cek apakah user admin sudah ada
        $existingAdmin = User::where('email', 'admin@pitychick.com')->first();
        
        if ($existingAdmin) {
            $this->command->info('Admin user already exists! Skipping...');
            return;
        }

        // Buat user admin baru hanya jika belum ada
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@pitychick.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@pitychick.com');
        $this->command->info('Password: password123');
        
        // Verifikasi data
        $this->command->table(
            ['ID', 'Name', 'Email', 'Role'],
            [[$admin->id, $admin->name, $admin->email, $admin->role]]
        );
    }
}