<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Authファサード
use App\Models\Income;
use App\Models\Type;
use App\Models\IncomeCategory;

class IncomeController extends Controller
{
    /**
     * 一覧表示 (ログインユーザーのみ)
     */
    public function index()
    {
        // ログインユーザーID取得
        $userId = Auth::id();

        // 「type」リレーションと「category」リレーションをまとめてロード
        // かつ、ユーザーIDで絞り込み
        $incomes = Income::with(['type', 'category'])
                    ->where('user_id', $userId)
                    ->get();

        // 全タイプ & 全カテゴリを取得 (表示用)
        $types = Type::all();
        $categories = IncomeCategory::all();

        // ユーザー一覧を使わないのであれば削除してOK
        // もしadmin向け等で全ユーザーを扱うなら残す
        // $users = User::all();

        return view('incomes.index', compact('incomes', 'types', 'categories'));
    }

    /**
     * 新規登録 (store)
     */
    public function store(Request $request)
    {
        // バリデーションルール (user_idは受け取らない)
        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'comment' => 'nullable|string',
            'type_id' => 'required|exists:types,id',
            'category_id' => 'required|exists:income_categories,id',
        ]);

        // ログインユーザーIDを取得
        $userId = Auth::id();

        // レコード作成: user_idはサーバ側で強制セット
        $income = Income::create([
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'comment' => $validated['comment'] ?? null,
            'type_id' => $validated['type_id'],
            'category_id' => $validated['category_id'],
            'user_id' => $userId,  // ログインユーザーを紐づけ
        ]);

        return response()->json([
            'success' => true,
            'message' => '収入を登録しました',
        ]);
    }

    /**
     * 更新 (update)
     */
    public function update(Request $request, $id)
    {
        // ログインユーザーIDを取得
        $userId = Auth::id();

        // 該当データを findOrFail
        $income = Income::where('user_id', $userId)
                    ->findOrFail($id);
        // ↑ user_idが自分のもの限定にすることで
        // 他人のIDを指定しても 404 が返る

        $validated = $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'comment' => 'nullable|string',
            'type_id' => 'required|exists:types,id',
            'category_id' => 'required|exists:income_categories,id',
        ]);

        // user_idは受け取らず、既存のまま
        // update
        $income->update($validated);

        return response()->json([
            'success' => true,
            'message' => '収入を更新しました',
        ]);
    }

    /**
     * 削除 (destroy) - ソフトデリート
     */
    public function destroy($id)
    {
        // ログインユーザーIDを取得
        $userId = Auth::id();

        // 自分のデータのみを検索
        $income = Income::where('user_id', $userId)
                    ->findOrFail($id);

        // 論理削除 (ソフトデリート)
        $income->delete();

        return response()->json([
            'success' => true,
            'message' => '収入を削除しました（論理削除）'
        ]);
    }
}
