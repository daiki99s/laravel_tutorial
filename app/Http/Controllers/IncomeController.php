<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('type')->get(); // typeリレーションも取得

        return view('incomes.index', compact('incomes')); // Blade にデータを渡す
    }
}
