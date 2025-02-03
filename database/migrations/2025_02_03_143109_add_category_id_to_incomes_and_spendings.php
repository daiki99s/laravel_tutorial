<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('amount')->nullable();
            $table->foreign('category_id')->references('id')->on('income_categories')->onDelete('cascade');
        });

        Schema::table('spendings', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('amount')->nullable();
            $table->foreign('category_id')->references('id')->on('spending_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::table('spendings', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

};
