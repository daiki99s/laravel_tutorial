<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spending extends Model
{
    use HasFactory;

    // どのカラムが書き換え可能かを指定
    protected $fillable = [
        'user_id', 'type_id', 'category_id', 'amount', 'date', 'comment'
    ];

    // Type とのリレーション（Spending は 1つの Type に属する）
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // User とのリレーション（Spending は 1人の User に属する）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // SpendingCategory とのリレーション（Spending は 1つの SpendingCategory に属する）
    public function category()
    {
        return $this->belongsTo(SpendingCategory::class, 'category_id');
    }
}
