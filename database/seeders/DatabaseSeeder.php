<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 依存関係が少ないマスタ系を先に実行
        $this->call([
            UserSeeder::class,      // ユーザー情報
            CategorySeeder::class,  // 商品カテゴリー
            ConditionSeeder::class, // 商品の状態
        ]);

        // 外部キーを持つアイテム系は後から実行
        $this->call([
            ItemSeeder::class,      // 商品情報
        ]);
    }
}
