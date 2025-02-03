<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpendingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('spendings', function (Blueprint $table) {
            $table->id(); // 自動採番の主キー
            $table->unsignedBigInteger('user_id')->comment('ユーザーID'); // ユーザーID（外部キー）
            $table->unsignedBigInteger('type_id')->comment('1: 支出, 2: 収入'); // カテゴリタイプ（外部キー）
            $table->bigInteger('amount')->comment('金額');
            $table->date('date')->comment('支出日');
            $table->text('comment')->nullable()->comment('メモ'); // メモ（NULL許可）
            $table->timestamps(); // created_at, updated_at 自動追加
            $table->softDeletes(); // LaravelのSoftDeletesを追加

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spendings');
    }
}
