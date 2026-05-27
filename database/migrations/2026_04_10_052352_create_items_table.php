<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // 出品者
            $table->string('name');                      // 商品名
            $table->string('brand')->nullable();         // ブランド名
            $table->text('description');                 // 商品説明
            $table->integer('price');                    // 価格
            $table->string('image_path');                // 商品画像パス
            $table->string('condition');                 // 商品の状態
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }

};
