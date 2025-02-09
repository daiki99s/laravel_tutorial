<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Type;
use App\Models\User;
use App\Models\IncomeCategory;

class IncomeController extends Controller
{
        /**
     * 一覧表示
     */
    public function index()
    {
        // 「type」リレーションと「category」リレーションをまとめてロード
        $incomes = Income::with(['type', 'category'])->get();
        $types = Type::all();
        $users = User::all();

        // すべての収入カテゴリを取得（カテゴリのプルダウンなどに使う想定）
        $categories = IncomeCategory::all();

        return view('incomes.index', compact('incomes', 'types', 'users', 'categories'));
    }
    /**
     * 新規登録 (store)
     */
    public function store(Request $request)
    {
        // バリデーションルール
        $validated = $request->validate([
            'date' => 'required|date', // 日付は必須かつ正しい日付形式
            'amount' => 'required|numeric|min:0', // 金額は必須かつ0以上の数値
            'comment' => 'nullable|string', // コメントは任意の文字列
            'type_id' => 'required|exists:types,id', // type_idはtypesテーブルに存在するIDであること
            'user_id' => 'required|exists:users,id', // user_idはusersテーブルに存在するIDであること
            'category_id' => 'required|exists:income_categories,id', // category_idはincome_categoriesテーブルに存在するIDであること
        ]);

        // レコード作成
        $income = Income::create([
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'comment' => $validated['comment'] ?? null, // コメントが空であればnull
            'type_id' => $validated['type_id'],
            'user_id' => $validated['user_id'],
            'category_id' => $validated['category_id'],
        ]);

        return response()->json([
            'success' => true,
            'message' => '収入を登録しました'
        ]);
    }

    /**
     * 更新 (update)
     */
    public function update(Request $request, $id)
{
  $income = Income::findOrFail($id);

  $validated = $request->validate([
      'date' => 'required|date',
      'amount' => 'required|numeric|min:0',
      'comment' => 'nullable|string',
      'type_id' => 'required|exists:types,id',
      'user_id' => 'required|exists:users,id',
      'category_id' => 'required|exists:income_categories,id',
  ]); // バリデーション

  $income->update($validated);
  return response()->json([
    'success' => true,
    'message' => '収入を更新しました'
]);}


}
