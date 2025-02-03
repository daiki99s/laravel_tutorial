<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpendingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('spendings')->insert([
            ['user_id' => 1, 'type_id' => 1, 'amount' => 3000, 'date' => '2024-02-01', 'comment' => 'ランチ', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 1, 'type_id' => 1, 'amount' => 15000, 'date' => '2024-02-02', 'comment' => '家賃', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
