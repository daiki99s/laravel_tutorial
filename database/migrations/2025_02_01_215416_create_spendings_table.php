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
            $table->unsignedBigInteger('user_id'); // ユーザーID（外部キー）
            $table->unsignedBigInteger('type_id'); // カテゴリーID（外部キー）
            $table->bigInteger('amount'); // 金額（整数）
            $table->date('date'); // 日付
            $table->text('comment')->nullable(); // メモ（NULL許可）
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
// このマイグレーションファイルでは、spendingsテーブルを作成するためのupメソッドと、テーブルを削除するためのdownメソッドが定義されています。
// upメソッドでは、Blueprintクラスのメソッドを使ってテーブルのカラムを定義しています。
// ここで、idメソッドは自動採番の主キーを定義するメソッドです。
// unsignedBigIntegerメソッドは、符号なしのBIGINT型のカラムを定義するメソッドです。
// bigIntegerメソッドは、BIGINT型のカラムを定義するメソッドです。
// dateメソッドは、DATE型のカラムを定義するメソッドです。
// textメソッドは、TEXT型のカラムを定義するメソッドです。
// nullableメソッドは、カラムにNULLを許可するメソッドです。
// timestampsメソッドは、created_atとupdated_atのカラムを自動追加するメソッドです。
// softDeletesメソッドは、deleted_atのカラムを追加するメソッドです。
// また、外部キー制約を設定するために、foreignメソッドを使ってusersテーブルとtypesテーブルのidカラムに対して外部キー制約を設定しています。
// onDeleteメソッドは、親テーブルのレコードが削除されたときの挙動を指定するメソッドです。
// cascadeを指定することで、親テーブルのレコードが削除されたときに、子テーブルのレコードも削除されるようになります。
// downメソッドでは、dropIfExistsメソッドを使ってspendingsテーブルを削除しています。
// このマイグレーションファイルを実行することで、spendingsテーブルが作成されます。
