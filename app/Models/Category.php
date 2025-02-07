<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InvalidCategoryException;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id'];

    /**
     * モデルの保存時にバリデーションを行う
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            if ($category->incomes()->exists() && $category->spendings()->exists()) {
                throw new InvalidCategoryException();
            }
        });
    }

    /**
     * Income とのリレーション（最新順）
     */
    public function incomes()
    {
        return $this->hasMany(Income::class, 'category_id')->orderBy('created_at', 'desc');
    }

    /**
     * Spending とのリレーション（最新順）
     */
    public function spendings()
    {
        return $this->hasMany(Spending::class, 'category_id')->orderBy('created_at', 'desc');
    }

    /**
     * カテゴリのタイプを判定（income or spending）
     */
    public function getTypeAttribute()
    {
        $incomeCount = $this->incomes()->count();
        $spendingCount = $this->spendings()->count();

        if ($incomeCount > 0 && $spendingCount > 0) {
            throw new InvalidCategoryException();
        }

        return $incomeCount > 0 ? 'income' : ($spendingCount > 0 ? 'spending' : null);
    }
}




// 構成
// DB: income_categories, spending_categories
// Model: Category(2テーブルのリレーションはこのモデルで行う)
// Controller: HomeController(レスポンスの処理), SpendingController(リクエストの処理), IncomeController(リクエストの処理)
