<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpendingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 既存データを削除
        DB::table('spendings')->truncate();

        // 各カテゴリのIDを取得
        $foodCategoryId = DB::table('spending_categories')->where('name', '食費')->value('id');
        $rentCategoryId = DB::table('spending_categories')->where('name', '家賃')->value('id');
        $transportCategoryId = DB::table('spending_categories')->where('name', '交通費')->value('id');

        DB::table('spendings')->insert([
            [
                'user_id' => 1,
                'type_id' => 1, // 支出のType ID
                'category_id' => $foodCategoryId, // 食費
                'amount' => 3000,
                'date' => '2024-02-01',
                'comment' => 'ランチ代',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'type_id' => 1,
                'category_id' => $rentCategoryId, // 家賃
                'amount' => 150000,
                'date' => '2024-02-02',
                'comment' => '家賃',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'type_id' => 1,
                'category_id' => $transportCategoryId, // 交通費
                'amount' => 8000,
                'date' => '2024-02-03',
                'comment' => '電車代',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
