<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Income とのリレーション
    public function incomes()
    {
        return $this->hasMany(Income::class, 'category_id');
    }

    // Spending とのリレーション
    public function spendings()
    {
        return $this->hasMany(Spending::class, 'category_id');
    }
}

// 構成
// DB: income_categories, spending_categories
// Model: Category(2テーブルのリレーションはこのモデルで行う)
// Controller: HomeController(レスポンスの処理), SpendingController(リクエストの処理), IncomeController(リクエストの処理)
