<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spending;
use App\Models\Type;
use App\Models\User;
use App\Models\SpendingCategory; // Spending用カテゴリモデル

class SpendingController extends Controller
{
    /**
     * 一覧表示
     */
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

    /**
     * 新規登録 (store)
     */
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
            'date'       => $validated['date'],
            'amount'     => $validated['amount'],
            'comment'    => $validated['comment'] ?? null,
            'type_id'    => $validated['type_id'],
            'user_id'    => $validated['user_id'],
            'category_id'=> $validated['category_id'],
        ]);

        return response()->json([
            'success' => true,
            'message' => '支出を登録しました'
        ]);
    }

    /**
     * 更新 (update)
     */
    public function update(Request $request, $id)
    {
        $spending = Spending::findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'comment' => 'nullable|string',
            'type_id' => 'required|exists:types,id',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:spending_categories,id',
        ]);

        // バリデーションを通過後、更新を実行
        $spending->update($validated);

        return response()->json([
            'success' => true,
            'message' => '支出を更新しました'
        ]);
    }

}
