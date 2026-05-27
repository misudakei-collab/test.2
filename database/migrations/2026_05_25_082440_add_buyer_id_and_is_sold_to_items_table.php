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
        Schema::table('items', function (Blueprint $table) {
            // 購入者IDを追加（usersテーブルと紐付け、未購入時はnullを許容）
            $table->foreignId('buyer_id')->nullable()->constrained('users')->onDelete('set null');
            // 売り切れフラグを追加（デフォルトは false = 販売中）
            $table->boolean('is_sold')->default(false);
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            // ロールバック（元に戻す）用の処理
            $table->dropForeign(['buyer_id']);
            $table->dropColumn(['buyer_id', 'is_sold']);
        });
    }
};


