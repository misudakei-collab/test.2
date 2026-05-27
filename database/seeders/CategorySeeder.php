<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['content' => 'ファッション'],
            ['content' => '家電・スマホ・カメラ'],
            ['content' => 'おもちゃ・ホビー・グッズ'],
            ['content' => 'インテリア・住まい・小物'],
            ['content' => '本・雑誌・漫画'],
            ['content' => 'スポーツ・レジャー'],
            ['content' => 'ハンドメイド'],
            ['content' => 'チケット'],
            ['content' => '自動車・オートバイ'],
            ['content' => 'その他'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}

