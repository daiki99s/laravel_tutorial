<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents; をSeeder クラスで
// use すると、モデルイベントが発火しなくなる。
// 例えば、IncomesTableSeeder で Income::create([...]) みたいに Eloquent を使って
// データを追加するときに、Income モデルの boot メソッド内の creating() や
// updating() イベントが発生しなくなる。
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // LaravelでのDBへのseedのコマンドは以下2パターン。
            // ①php artisan db:seed --class=UsersTable::class,
            // ↑はSeedしたいテーブルごとにコマンドを打つ事ができる。
            //このパターンだとUsersTableSeeder.phpに記述したテーブルのみSeedする。
            // ②php artisan db:seed
            // ↑はDatabaseSeeder.phpに記述したテーブルを全てSeedする。

            // UsersTableSeeder::class,
            // TypesTableSeeder::class,
            IncomeCategoriesTableSeeder::class,
            SpendingCategoriesTableSeeder::class,
            IncomesTableSeeder::class,
            SpendingsTableSeeder::class,
        ]);
    }
}
