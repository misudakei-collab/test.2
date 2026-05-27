<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Item $item)
    {
        $user = Auth::user();

        // すでにいいねしていれば解除、していなければ登録
        $user->likedItems()->toggle($item->id);

        return back();
    }
}
