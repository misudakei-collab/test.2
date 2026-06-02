<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;

// =========================================================================
// 公開ルート（ログイン不要）
// =========================================================================
Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');


// =========================================================================
// ログイン必須のルート
// =========================================================================
Route::middleware('auth')->group(function () {

    // ---------------------------------------------------------------------
    // --- 🔒 メール認証済み（リンククリック後）のみ許可するグループ ---
    // ---------------------------------------------------------------------
    Route::middleware(['verified'])->group(function () {

        // マイページや機能系（認証前は完全にブロックされます）
        Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage.index');
        Route::post('/item/{item}/like', [LikeController::class, 'toggle'])->name('like.toggle');
        Route::post('/item/{item}/comment', [ItemController::class, 'commentStore'])->name('comment.store');

        // プロフィール設定
        Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

        // 住所変更画面・保存処理
        Route::get('/purchase/address/{item}', [ProfileController::class, 'editAddress'])->name('address.edit');
        Route::post('/purchase/address/{item}', [ProfileController::class, 'updateAddress'])->name('address.update');

        // 出品機能
        Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
        Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

        // 購入機能（購入確認・Stripe決済・サンクスページ）
        Route::get('/purchase/{item}', [ItemController::class, 'purchase'])->name('item.purchase');
        Route::post('/purchase/{item}/checkout', [ItemController::class, 'checkout'])->name('item.checkout');
        Route::get('/purchase/{item}/thanks', [ItemController::class, 'thanks'])->name('item.thanks');
    });
});
