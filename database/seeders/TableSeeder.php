<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['number' => 'A1', 'capacity' => 2, 'status' => 'available'],
            ['number' => 'A2', 'capacity' => 4, 'status' => 'reserved'],
            ['number' => 'B1', 'capacity' => 6, 'status' => 'available'],
            ['number' => 'B2', 'capacity' => 4, 'status' => 'unavailable'],
            ['number' => 'C1', 'capacity' => 2, 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}
