<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function store(Request $request, Item $item)
    {
        // 1. すでに売り切れていないかチェック
        if ($item->is_sold) {
            return back()->with('error', 'この商品は既に売り切れています。');
        }

        // 2. 商品情報を更新（購入者IDとフラグ）
        $item->update([
            'is_sold' => true,
            'buyer_id' => Auth::id(),
        ]);

        // 3. 完了メッセージとともにリダイレクト
        return redirect()->route('item.show', $item)->with('message', '購入が完了しました！');
    }
}
