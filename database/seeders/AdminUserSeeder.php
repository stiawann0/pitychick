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

        // Buat user admin baru (HAPUS 'is_admin' dan 'phone' jika tidak ada)
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@pitychick.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_ADMIN, // PAKAI INI SAJA
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@pitychick.com');
        $this->command->info('Password: password123');
        
        // Verifikasi data (HAPUS reference ke is_admin)
        $this->command->table(
            ['ID', 'Name', 'Email', 'Role'],
            [[$admin->id, $admin->name, $admin->email, $admin->role]]
        );
    }
}