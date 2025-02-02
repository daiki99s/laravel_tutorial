<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_type'];

    // Spending とのリレーション（Type は 複数の Spending を持つ）
    public function spendings()
    {
        return $this->hasMany(Spending::class);
    }
}

