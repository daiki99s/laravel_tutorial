<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Spending;
use App\Models\Type;
use App\Models\User;
use App\Models\IncomeCategory;
use App\Models\SpendingCategory;

class HomeController extends Controller
{
    public function index()
    {
        // 収入、支出、タイプ、ユーザーを取得
        $incomes = Income::with(['type','category'])->get();
        $spendings = Spending::with(['type','category'])->get();
        $types = Type::all();
        $users = User::all();

        // それぞれのカテゴリを別の変数に取得
        $incomeCategories = IncomeCategory::all();
        $spendingCategories = SpendingCategory::all();

        // Blade に渡す
        return view('home', compact('incomes', 'spendings', 'types', 'users', 'incomeCategories', 'spendingCategories'));
    }

}
