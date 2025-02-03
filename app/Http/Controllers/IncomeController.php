<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Type;
use App\Models\User;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('type')->get(); // typeリレーションも取得
        $types = Type::all(); // すべてのタイプを取得
        $users = User::all(); // すべてのユーザーを取得
        return view('incomes.index', compact('incomes', 'types', 'users')); // Blade にデータを渡す
    }

    public function store(Request $request)
    {
        // バリデーションルールを追加
        $validated = $request->validate([
            'date' => 'required|date', // 日付は必須かつ正しい日付形式
            'amount' => 'required|numeric|min:0', // 金額は必須かつ0以上の数値
            'comment' => 'nullable|string', // コメントは任意の文字列
            'type_id' => 'required|exists:types,id', // type_idはtypesテーブルに存在するIDであること
            'user_id' => 'required|exists:users,id', // user_idはusersテーブルに存在するIDであること
        ]);

        // バリデーションを通過したデータで新しいIncomeを作成
        $income = Income::create([
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'comment' => $validated['comment'] ?? null, // コメントが空であればnull
            'type_id' => $validated['type_id'],
            'user_id' => $validated['user_id'],
        ]);
    return redirect()->route('home')->with('message', '収入を登録しました');
    }
}
