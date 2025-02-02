<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            ['name' => '収入','category_type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '支出','category_type' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
