<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SpendingCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('spending_categories')->insert([
            [
                'name' => '食費',
                'description' => '飲食にかかる費用',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '家賃',
                'description' => '住居にかかる費用',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '交通費',
                'description' => '移動にかかる費用',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
