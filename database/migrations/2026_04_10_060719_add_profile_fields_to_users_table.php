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
        Schema::table('users', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('password'); // プロフィール画像
            $table->string('postal_code')->nullable()->after('image_url'); // 郵便番号
            $table->string('address')->nullable()->after('postal_code'); // 住所
            $table->string('building')->nullable()->after('address'); // 建物名
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
