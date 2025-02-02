<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('incomes')->insert([
            ['user_id' => 1, 'type_id' => 1, 'amount' => 50000, 'date' => '2024-02-01', 'comment' => '給与', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'type_id' => 1, 'amount' => 10000, 'date' => '2024-02-02', 'comment' => 'ボーナス', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
