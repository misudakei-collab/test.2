<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            ['condition' => '良好'],
            ['condition' => '目立った傷や汚れなし'],
            ['condition' => 'やや傷や汚れあり'],
            ['condition' => '状態が悪い'],
        ];

        foreach ($conditions as $condition) {
            // 💡 createの代わりにupdateOrCreateを使うことで、重複登録を防ぎます
            \App\Models\Condition::updateOrCreate(
                ['condition' => $condition['condition']], // すでに同じ文字列があるかチェック
                $condition // なければ新規作成、あれば上書き（増えない）
            );
        }
    }
}

