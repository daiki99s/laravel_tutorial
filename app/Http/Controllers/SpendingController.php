<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spending;

class SpendingController extends Controller
{
    public function index()
    {
        // Spending のデータを取得（リレーションも一緒に）
        $spendings = Spending::with('type')->get();

        // Blade に渡す
        return view('spendings.index', compact('spendings'));
    }
}
