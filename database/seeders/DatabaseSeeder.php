<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // HAPUS BAGIAN INI - karena sudah ada di AdminUserSeeder
        // User::create([
        //     'name' => 'wahyu stiawan',
        //     'email' => 'wahyustiawan763@gmail.com',
        //     'password' => bcrypt('password'),
        //     'role' => User::ROLE_ADMIN
        // ]);

        // Create sample customers
        User::factory(10)->create([
            'role' => User::ROLE_CUSTOMER
        ]);

        $this->call([
            AdminUserSeeder::class,
            TableSeeder::class,
        ]);

        $this->call(MenuSeeder::class);
    }
}