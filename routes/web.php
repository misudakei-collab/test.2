<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;

// 公開ルート（ログイン不要）
Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

// ログイン必須のルート
Route::middleware('auth')->group(function () {

    // いいね機能
    Route::post('/item/{item}/like', [LikeController::class, 'toggle'])->name('like.toggle');

    // マイページ
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage.index');

    // コメント投稿処理
    Route::post('/item/{item}/comment', [App\Http\Controllers\CommentController::class, 'store'])->name('comment.store');



    // --- メール認証済みのみ許可するグループ ---
    Route::middleware(['verified'])->group(function () {

        // プロフィール設定
        Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

        // 住所変更画面の表示
        Route::get('/item/{item}/address', [ProfileController::class, 'editAddress'])->name('address.edit');
        
        // 住所変更の保存処理
        Route::post('/item/{item}/address', [ProfileController::class, 'updateAddress'])->name('address.update');


        // 出品機能
        Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
        Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

        // 購入機能
        // 1. 購入確認画面を表示 (GET)
        Route::get('/item/{item}/purchase', [ItemController::class, 'purchase'])->name('item.purchase');

            // Stripe決済処理を行うルート（従来のbuyから変更）
            Route::post('/item/{item}/checkout', [ItemController::class, 'checkout'])->name('item.checkout');

            // 購入完了画面（サンクスページ）
            Route::get('/item/{item}/thanks', [ItemController::class, 'thanks'])->name('item.thanks');
        });
});
