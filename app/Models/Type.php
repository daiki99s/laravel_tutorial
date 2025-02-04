<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_type'];

    // Income とのリレーション（Type は 複数の Income を持つ）
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
    // Spending とのリレーション（Type は 複数の Spending を持つ）
    public function spendings()
    {
        return $this->hasMany(Spending::class);
    }
}

// 構成
// DB: types
// Model: Types
// Controller: HomeController(レスポンスの処理), SpendingController(リクエストの取得), IncomeController(リクエストの取得)

