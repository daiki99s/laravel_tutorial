<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Spending;
use App\Models\Type; // ここでTypeモデルを追加
use App\Models\User;
use App\Models\Category; // ここでCategoryモデルを追加

class HomeController extends Controller
{
    public function index()
    {
        // 収入、支出、タイプ、ユーザーを取得
        $incomes = Income::with('type')->get();
        $spendings = Spending::with('type')->get();
        $types = Type::all(); // typesテーブルからタイプデータを取得
        $users = User::all(); // usersテーブルからユーザーデータを取得
        // todo
        // 1.Categoryモデルを作成
        // 2.Categoryモデルにincome_categories, spending_categoriesリレーションを追加
        // 3.ここでCategryモデルからリレーション取得
        // 4.ビューにデータを渡す
        // $categoties = Category::all();
        // categoriesテーブルからカテゴリーデータを取得
        return view('home', compact('incomes', 'spendings', 'types', 'users')); // Blade にデータを渡す
    }
}
