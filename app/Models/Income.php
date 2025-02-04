<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type_id', 'amount', 'date', 'comment'];

    // Type モデルとのリレーション (Income は Type に属する)
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // User モデルとのリレーション (Income は User に属する)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
