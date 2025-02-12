<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Spending;
use App\Models\Type;
use App\Models\User;
use App\Models\IncomeCategory;
use App\Models\SpendingCategory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // ログインユーザーID
        $userId = Auth::id();

        // ログインユーザーの収入だけ取得
        $incomes = Income::with(['type', 'category'])
                    ->where('user_id', $userId)
                    ->get();

        // ログインユーザーの支出だけ取得
        $spendings = Spending::with(['type', 'category'])
                    ->where('user_id', $userId)
                    ->get();

        // すべての Type (収入 or 支出タイプ)
        $types = Type::all();

        // すべてのカテゴリ (収入カテゴリ / 支出カテゴリ)
        $incomeCategories = IncomeCategory::all();
        $spendingCategories = SpendingCategory::all();

        // 必要ならユーザー一覧を取得（管理者向けなど）
        // $users = User::all();
        // ただし通常ユーザーには不要かもしれません

        // Blade に渡す
        return view('home', compact(
            'incomes',
            'spendings',
            'types',
            'incomeCategories',
            'spendingCategories'
        ));
    }
}
