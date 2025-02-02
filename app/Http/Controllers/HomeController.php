<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Spending;

class HomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('type')->get();
        $spendings = Spending::with('type')->get();

        return view('home', compact('incomes', 'spendings'));
        $incomeTypes = IncomeType::all(); // 追加
        return view('home', compact('incomeTypes')); // 追加
    }
}
