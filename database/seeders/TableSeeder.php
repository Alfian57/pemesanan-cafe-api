<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = [
            [
                'name' => 'FAMILY',
                'capacity' => 6,
                'description' => 'Table for family with 6 people',
                'loop' => 4,
            ],
            [
                'name' => 'COUPLE',
                'capacity' => 2,
                'description' => 'Table for couple with 2 people',
                'loop' => 8,
            ],
            [
                'name' => 'SINGLE',
                'capacity' => 1,
                'description' => 'Table for single with 1 person',
                'loop' => 10,
            ],
        ];

        foreach ($tables as $table) {
            for ($i = 0; $i < $table['loop']; $i++) {
                \App\Models\Table::create([
                    'name' => $table['name'],
                    'capacity' => $table['capacity'],
                    'description' => $table['description'],
                ]);
            }
        }
    }
}
