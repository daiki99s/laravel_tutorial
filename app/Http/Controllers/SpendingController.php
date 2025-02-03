<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spending;
use App\Models\Type;
use App\Models\User;

class SpendingController extends Controller
{
    public function index()
    {
        $spendings = Spending::with('type')->get();// Spending のデータを取得（リレーションも一緒に）
        $types = Type::all(); // すべてのタイプを取得
        $users = User::all(); // すべてのユーザーを取得
        // Blade に渡す
        return view('spendings.index', compact('spendings', 'types', 'users'));
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

        // バリデーションを通過したデータで新しいSpendingを作成
        $spending = Spending::create([
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'comment' => $validated['comment'] ?? null, // コメントが空であればnull
            'type_id' => $validated['type_id'],
            'user_id' => $validated['user_id'],
        ]);
        return redirect()->route('home')->with('message', '支出を登録しました');
    }
}
