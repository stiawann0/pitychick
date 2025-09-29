<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // Original
            ['name' => 'Dada', 'category' => 'original', 'price' => 17000, 'description' => 'Nasi, ayam krispi, saus sayur krispi'],
            ['name' => 'Paha Atas', 'category' => 'original', 'price' => 17000, 'description' => 'Nasi, ayam krispi, saus sayur krispi'],
            ['name' => 'Paha Bawah', 'category' => 'original', 'price' => 10000, 'description' => 'Nasi, ayam krispi, saus sayur krispi'],
            ['name' => 'Sayap', 'category' => 'original', 'price' => 12000, 'description' => 'Nasi, ayam krispi, saus sayur krispi'],

            // Tambahan
            ['name' => 'Krisbar', 'category' => 'tambahan', 'price' => 3000, 'description' => 'Paket komplit'],
            ['name' => 'Geprek Alapity', 'category' => 'tambahan', 'price' => 3000, 'description' => 'Paket komplit'],
            ['name' => 'Spicy Cheese', 'category' => 'tambahan', 'price' => 4000, 'description' => 'Paket komplit'],
            ['name' => 'Curry', 'category' => 'tambahan', 'price' => 3000, 'description' => 'Paket komplit'],
            ['name' => 'Gulai', 'category' => 'tambahan', 'price' => 3000, 'description' => 'Paket komplit'],
            ['name' => 'Blackpepper', 'category' => 'tambahan', 'price' => 3000, 'description' => 'Paket komplit'],

            // Snack
            ['name' => 'Kulit Original', 'category' => 'snack', 'price' => 10000, 'description' => "Add Sauce + 3.000"],
            ['name' => 'French Fries', 'category' => 'snack', 'price' => 10000],
            ['name' => 'Spicy Wings', 'category' => 'snack', 'price' => 18000],

            // Rame-rame Mania
            ['name' => 'Whole Chicken', 'category' => 'rame-rame mania', 'price' => 90000, 'description' => 'Ayam Krispi 1 Ekor Nasi 6 Porsi & Pilih 3 Saus'],
            ['name' => 'Chicken Steak', 'category' => 'rame-rame mania', 'price' => 22000],

            // Minuman
            ['name' => 'Teh', 'category' => 'minuman', 'price' => 4000],
            ['name' => 'Teh Kampul', 'category' => 'minuman', 'price' => 5000],
            ['name' => 'Jeruk', 'category' => 'minuman', 'price' => 5000],
            ['name' => 'Air Mineral', 'category' => 'minuman', 'price' => 4000],
            ['name' => 'Cola', 'category' => 'minuman', 'price' => 8000],
            ['name' => 'Squash', 'category' => 'minuman', 'price' => 10000],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
