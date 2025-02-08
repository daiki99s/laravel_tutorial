<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    // テーブル名を手動で指定
    protected $table = 'income_categories';

    // 必要なカラムを $fillable で指定
    protected $fillable = [
        'name',
        'description',
    ];

    // リレーションを定義（Incomeとの関係など）
    public function incomes()
    {
        return $this->hasMany(Income::class, 'category_id');
    }
}
