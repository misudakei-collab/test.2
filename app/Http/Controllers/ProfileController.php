<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', ['user' => $user]);
    }

    // 住所変更画面の表示
    public function editAddress(Item $item)
    {
        $user = auth()->user();
        return view('profile.address', compact('user', 'item'));
    }

    // 住所変更の保存処理
    public function updateAddress(Request $request, Item $item)
    {
        // バリデーション
        $request->validate([
            'postal_code' => 'required',
            'address'     => 'required',
            'building'    => 'nullable',
        ], [
            'postal_code.required' => '郵便番号を入力してください。',
            'address.required'     => '住所を入力してください。',
        ]);


        auth()->user()->update([
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building, // DBにカラムがある前提
        ]);

        // 更新完了後、元の商品の購入確認画面へスマートに戻す！
        return redirect()->route('item.purchase', $item)->with('message', '配送先住所を更新しました！');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'postal_code' => 'required',
            'address' => 'required',
        ], [
            'name.required' => 'お名前を入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'address.required' => '住所を入力してください',
        ]);

        $user = auth()->user();

        // 1. 画像が送られてきたら保存してパスをセット
        if ($request->hasFile('image')) {
            if ($user->image_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->image_url)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image_url);
            }

            $path = $request->file('image')->store('profiles', 'public');
            $user->image_url = $path; // ここで画像パスを代入
        }

        // 2. その他のテキスト項目をまとめて代入
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building ?? null; // 建物名は任意

        // 3. 最後にまとめてデータベースに保存
        $user->save();

        return redirect()->route('profile.edit')->with('message', 'プロフィールを更新しました');
    }

    // 2. マイページ用の表示処理
     public function index(Request $request)
    {
        $page = $request->query('page', 'sell');
        $user = Auth::user();

        // ログインしていない場合の安全対策
        if (!$user) {
            return redirect()->route('login');
        }

        if ($page === 'buy') {
            // 🛒 「購入した商品」タブの場合：自分が購入した商品を最新順で取得
            $items = Item::where('buyer_id', $user->id)->latest()->get();
        } else {
            // 📦 「出品した商品」タブの場合：自分が出品した商品を最新順で取得
            $items = Item::where('user_id', $user->id)->latest()->get();
        }

        // 💡 戻す画面はマイページのビュー（'mypage.index'）です
        return view('mypage.index', compact('items', 'page', 'user'));
    }
}
