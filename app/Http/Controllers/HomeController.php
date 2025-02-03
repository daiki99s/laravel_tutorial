<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Spending;
use App\Models\Type; // ここでTypeモデルを追加
use App\Models\User;
class HomeController extends Controller
{
    public function index()
    {
        // 収入、支出、タイプ、ユーザーを取得
        $incomes = Income::with('type')->get();
        $spendings = Spending::with('type')->get();
        // dd($incomes);テスト：値が取れているか確認　オブジェクトで返される（？）
        // dd($spendings);テスト：値が取れているか確認 オブジェクトで返される（？）
        $types = Type::all(); // typesテーブルからタイプデータを取得
        $users = User::all(); // usersテーブルからユーザーデータを取得
        return view('home', compact('incomes', 'spendings', 'types', 'users')); // Blade にデータを渡す
    }
}
