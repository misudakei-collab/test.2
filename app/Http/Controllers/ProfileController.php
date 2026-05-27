<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面の表示
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', ['user' => $user]);
    }

    /**
     * 住所変更画面の表示
     */
    public function editAddress(Item $item)
    {
        $user = auth()->user();
        return view('profile.address', compact('user', 'item'));
    }

    /**
     * 住所変更の保存処理（AddressRequestに準拠）
     */
    public function updateAddress(Request $request, Item $item)
    {
        $request->validate([
            'postal_code' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address'     => 'required|string',
            'building'    => 'nullable',
        ], [
            // 💡 メッセージ
            'postal_code.required' => '入力必須',
            'postal_code.regex'    => 'ハイフンありの8文字',
            'address.required'     => '入力必須',
        ]);

        auth()->user()->update([
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ]);

        return redirect()->route('item.purchase', $item)->with('message', '配送先住所を更新しました！');
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        $request->validate([
            'image'       => 'nullable|image|mimes:jpeg,png|max:2048',
            'name'        => 'required|string|max:20',
            'postal_code' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address'     => 'required|string',
        ], [
            // 💡 メッセージ
            'image.image'          => '画像ファイルを選択してください',
            'image.mimes'          => '拡張子が.jpegもしくは.png',
            'name.required'        => '入力必須',
            'name.max'             => '20文字以内',
            'postal_code.required' => '入力必須',
            'postal_code.regex'    => 'ハイフンありの8文字',
            'address.required'     => '入力必須',
        ]);

        $user = auth()->user();

        // 1. 画像の保存処理
        if ($request->hasFile('image')) {
            if ($user->image_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->image_url)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image_url);
            }

            $path = $request->file('image')->store('profiles', 'public');
            $user->image_url = $path;
        }

        // 2. テキスト項目の代入
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building ?? null;

        // 3. 保存
        $user->save();

        return redirect()->route('profile.edit')->with('message', 'プロフィールを更新しました');
    }

    /**
     * マイページ用の表示処理（お気に入り対応版）
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 'sell');
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 💡 お気に入り（like）の条件分岐を追加しました
        if ($page === 'buy') {
            // 🛒 「購入した商品」一覧
            $items = Item::where('buyer_id', $user->id)->latest()->get();
        } elseif ($page === 'like') {
            // ❤️ 「お気に入り（いいね）した商品」一覧
            $items = $user->likedItems()->latest()->get();
        } else {
            // 📦 「出品した商品」一覧
            $items = Item::where('user_id', $user->id)->latest()->get();
        }

        return view('mypage.index', compact('items', 'page', 'user'));
    }
}
