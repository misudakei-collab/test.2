<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Item $item)
    {
        // 1. 入力チェック（バリデーション）
        $request->validate([
            'body' => 'required|max:1000',
        ]);

        // 2. データベースにコメントを保存
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'body'    => $request->body,
        ]);

        // 3. 元の商品詳細画面に戻る
        return redirect()->route('item.show', $item->id)->with('message', 'コメントを投稿しました！');
    }
}
