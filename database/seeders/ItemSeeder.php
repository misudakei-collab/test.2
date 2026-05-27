<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $item = Item::create([
            'user_id'     => 1,
            'name'        => '腕時計',
            'price'       => 15000,
            'description' => '数回使用した程度の美品です。',
            'image_path'  => 'items/watch.jpg',
            'condition'   => '良好',
            'brand'       => 'ロレックス',
        ]);

        // これで $item が定義されているので、エラーになりません
        $item->categories()->attach(1);
    }
}
