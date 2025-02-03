<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IncomesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 一度テーブルのデータを削除する
        DB::table('incomes')->truncate();

        // 各カテゴリのIDを取得
        $salaryCategoryId = DB::table('income_categories')->where('name', '給与')->value('id');
        $sideJobCategoryId = DB::table('income_categories')->where('name', '副業')->value('id');
        $investmentCategoryId = DB::table('income_categories')->where('name', '投資')->value('id');

        DB::table('incomes')->insert([
            [
                'amount' => 300000,
                'category_id' => $salaryCategoryId, // 給与
                'comment' => '2月の給与',
                'date' => '2024-02-01',
                'user_id' => 1,
                'type_id' => 2, // 適切なType IDを設定
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'amount' => 100000,
                'category_id' => $sideJobCategoryId, // 副業
                'comment' => '冬のボーナス',
                'date' => '2024-02-15',
                'user_id' => 1,
                'type_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'amount' => 50000,
                'category_id' => $investmentCategoryId, // 投資
                'comment' => '副業の収益',
                'date' => '2024-02-20',
                'user_id' => 1,
                'type_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
