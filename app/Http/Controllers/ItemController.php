<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Condition;
use App\Models\Category;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class ItemController extends Controller
{
    /**
     * 出品画面の表示
     */
    public function create()
    {
        $conditions = Condition::all();
        $categories = Category::all();

        return view('item.create', compact('conditions', 'categories'));
    }

    /**
     * 商品の保存処理
     */
    public function store(Request $request)
    {
        // 💡 バリデーション定義書のルールに100%合わせる
        $request->validate([
            'name'         => 'required',
            'description'  => 'required|max:255',
            'image'        => 'required|image|mimes:jpeg,png|max:2048',
            'categories'   => 'required|array',
            'condition_id' => 'required',
            'price'        => 'required|integer|min:0',
        ], [
            // 💡 エラーメッセージの文言を定義書の表記に完全に合わせる
            'name.required'         => '入力必須',
            'description.required'  => '入力必須',
            'description.max'       => '最大文字数255',
            'image.required'        => 'アップロード必須',
            'image.image'           => '画像ファイルを選択してください',
            'image.mimes'           => '拡張子が.jpegもしくは.png',
            'image.max'             => '画像サイズは2MB以内でアップロードしてください。',
            'categories.required'   => '選択必須',
            'condition_id.required' => '選択必須',
            'price.required'        => '入力必須',
            'price.integer'         => '数値型',
            'price.min'             => '0円以上',
        ]);

        // 画像を保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
        } else {
            return back()->withErrors(['image' => '画像のアップロードに失敗しました。'])->withInput();
        }

        // データベースに保存
        $item = Item::create([
            'user_id'      => auth()->id(),
            'name'         => $request->name,
            'brand'        => $request->brand ?? null,
            'description'  => $request->description,
            'price'        => $request->price,
            'image_path'   => $path,
            'condition'    => $request->condition_id,
        ]);

        $item->categories()->attach($request->categories);

        return redirect()->route('item.create')->with('message', '商品を出品しました！');
    }

    /**
     * 商品一覧（トップページ・タブ切り替え対応版）
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $tab = 'recommend';
        } else {
            $tab = $request->query('tab', 'recommend');
        }

        $query = Item::query();

        // 1. タブに応じた条件分岐
        if ($tab === 'like') {
            if (Auth::check()) {
                $query->whereHas('likedItems', function($q) {
                    $q->where('user_id', Auth::id());
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        } else {
            // おすすめタブ：自分が出品した商品は表示しない
            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }
        }

        // 2. 検索キーワードの処理（ブランド検索対応）
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%")
                  ->orWhere('brand', 'LIKE', "%{$keyword}%");
            });
        }

        $items = $query->latest()->get();

        return view('index', compact('items', 'keyword', 'tab'));
    }

    /**
     * 商品詳細
     */
    public function show(Item $item)
    {
        if ($item->is_sold && (!Auth::check() || $item->buyer_id !== Auth::id())) {
            return redirect()->route('item.index')->with('error', 'この商品は売り切れのため詳細を表示できません');
        }


        $item->load(['categories', 'itemCondition']);

        return view('item.show', compact('item'));
    }

    /**
     * 購入済み商品一覧
     */
    public function purchasedItems()
    {
        $items = Item::where('buyer_id', auth()->id())->get();
        return view('item.purchased', compact('items'));
    }

    /**
     * ① 購入確認画面
     */
    public function purchase(Item $item)
    {
        if ($item->user_id === auth()->id()) {
            return redirect()->route('item.show', $item)->with('error', '自分が出品した商品は購入できません。');
        }
        if ($item->is_sold) {
            return redirect()->route('item.show', $item)->with('error', 'この商品はすでに売り切れです。');
        }
        return view('item.purchase', compact('item'));
    }

    /**
     * ② 決済・確定処理（支払い方法による分岐対応版）
     */
    public function checkout(Item $item, Request $request)
    {
        if ($item->is_sold) {
            return redirect()->route('item.index')->with('error', 'この商品はすでに売り切れです。');
        }

        // 画面から送られてきた支払い方法を取得
        $paymentMethod = $request->input('payment_method');

        // 💳 A. クレジットカード払いが選ばれた場合 ➡️ Stripe決済へ
        if ($paymentMethod === 'card') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('item.thanks', $item),
                'cancel_url' => route('item.purchase', $item),
            ]);

            // データベースの状態を購入済みに更新
            $item->update([
                'buyer_id' => auth()->id(),
                'is_sold' => true,
            ]);

            return redirect()->away($checkoutSession->url);
        }

        // 🏪 B. コンビニ払いが選ばれた場合 ➡️ Stripeを通さず即完了画面へ
        if ($paymentMethod === 'konbini') {
            // データベースの状態を購入済みに更新
            $item->update([
                'buyer_id' => auth()->id(),
                'is_sold' => true,
            ]);

            return redirect()->route('item.thanks', $item)->with('message', 'コンビニ支払いの受け付けが完了しました。');
        }

        // 万が一、どちらも選ばれていなければ購入画面に戻す
        return redirect()->route('item.purchase', $item)->with('error', '支払い方法を正しく選択してください。');
    }

    /**
     * ③ 購入完了画面（サンクスページ）の表示
     */
    public function thanks(Item $item)
    {
        return view('item.thanks', compact('item'));
    }

        /**
     * 💡 新設：コメントの投稿・保存処理
     */
    public function commentStore(Request $request, $itemId)
    {
        // 1. バリデーションチェック（空欄での送信をブロック）
        $request->validate([
            'comment' => 'required|max:255',
        ], [
            'comment.required' => 'コメント内容を入力してください。',
            'comment.max'      => 'コメントは255文字以内で入力してください。',
        ]);

        // 2. データベース（commentsテーブル）に確実に保存
        \App\Models\Comment::create([
            'user_id' => auth()->id(), // ログインしているユーザーのID
            'item_id' => $itemId,      // 対象の商品のID
            'body'    => $request->comment, // 送られてきたコメント本文
        ]);

        // 3. コメントを打った元の商品の詳細画面へメッセージ付きで戻す
        return back()->with('message', 'コメントを投稿しました！');
    }


}
