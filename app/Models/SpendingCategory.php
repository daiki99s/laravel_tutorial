<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpendingCategory extends Model
{
    use HasFactory;

    protected $table = 'spending_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    // リレーション（Spendingとの関係など）
    public function spendings()
    {
        return $this->hasMany(Spending::class, 'category_id');
    }
}
