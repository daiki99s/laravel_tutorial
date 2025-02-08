<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spending;
use App\Models\Type;
use App\Models\User;
use App\Models\SpendingCategory; // Spending用カテゴリモデル

class SpendingController extends Controller
{
    public function index()
    {
        // 「type」リレーションと「category」リレーションをまとめてロード
        $spendings = Spending::with(['type', 'category'])->get();

        $types = Type::all();
        $users = User::all();

        // すべての支出カテゴリを取得（カテゴリのプルダウンなどに使う想定）
        $categories = SpendingCategory::all();

        return view('spendings.index', compact('spendings', 'types', 'users', 'categories'));
    }

    public function store(Request $request)
    {
        // バリデーションルール
        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'comment' => 'nullable|string',
            'type_id' => 'required|exists:types,id',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:spending_categories,id', // 支出カテゴリを参照
        ]);

        // レコード作成
        $spending = Spending::create([
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'comment' => $validated['comment'] ?? null,
            'type_id' => $validated['type_id'],
            'user_id' => $validated['user_id'],
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('home')->with('message', '支出を登録しました');
    }
}
