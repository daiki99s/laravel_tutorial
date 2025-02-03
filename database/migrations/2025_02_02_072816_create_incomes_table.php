<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id(); // 自動採番の主キー
            $table->unsignedBigInteger('user_id')->comment('ユーザーID'); // ユーザーID（外部キー）
            $table->unsignedBigInteger('type_id')->comment('1: 支出, 2: 収入'); // カテゴリタイプ（外部キー）
            $table->bigInteger('amount')->comment('金額'); // 金額（整数）
            $table->date('date')->comment('収入日'); // 日付
            $table->text('comment')->nullable()->comment('メモ'); // メモ（NULL許可）
            $table->timestamps(); // created_at, updated_at 自動追加
            $table->softDeletes(); // ソフトデリート対応

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
