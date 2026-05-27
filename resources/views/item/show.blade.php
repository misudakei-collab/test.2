@include('layouts.header')

<!-- 通知メッセージ（レイアウトの上部に配置） -->
<div style="max-width: 1000px; margin: 20px auto 0 auto; padding: 0 20px;">
    @if (session('message'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 4px;">
            {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 4px;">
            {{ session('error') }}
        </div>
    @endif
</div>

<!-- 📦 全体を包むメインコンテナ（左右の2カラムに分割） -->
<div style="max-width: 1000px; margin: 0 auto; padding: 40px 20px; display: flex; gap: 60px;">

    <!-- 1️⃣ 左側カラム：商品画像エリア（幅45%） -->
    <div style="width: 45%; flex-shrink: 0;">
        <div style="width: 100%; aspect-ratio: 1 / 1; background-color: #f5f5f5; display: flex; justify-content: center; align-items: center; border-radius: 4px; overflow: hidden;">
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    <!-- 2️⃣ 右側カラム：詳細情報・購入・コメントエリア（幅55%） -->
    <div style="width: 55%; display: flex; flex-direction: column; gap: 35px;">

        <!-- 商品基本情報ヘッダー -->
        <div>
            <h1 style="font-size: 2.2em; font-weight: bold; margin: 0 0 5px 0; color: #111;">{{ $item->name }}</h1>
            <p style="color: #666; font-size: 0.95em; margin: 0 0 15px 0;">{{ $item->brand ?? '設定なし' }}</p>

            <p style="font-size: 2em; font-weight: bold; margin: 0 0 20px 0; color: #111;">
                ¥{{ number_format($item->price) }} <span style="font-size: 0.45em; font-weight: normal; color: #666;">（税込）</span>
            </p>

            <!-- 👍 いいね！ボタンエリア -->
            <div style="display: flex; gap: 25px; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                @auth
                    <form action="{{ route('like.toggle', $item->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0; display: flex; flex-direction: column; align-items: center; line-height: 1.2;">
                            @if($item->isLikedBy(Auth::user()))
                                <span style="font-size: 1.6em;">❤️</span>
                            @else
                                <span style="font-size: 1.6em;">🤍</span>
                            @endif
                            <span style="font-size: 0.75em; color: #666; margin-top: 4px;">{{ $item->likes()->count() }}</span>
                        </button>
                    </form>
                @else
                    <div style="display: flex; flex-direction: column; align-items: center; line-height: 1.2;">
                        <span style="font-size: 1.6em;">❤️</span>
                        <span style="font-size: 0.75em; color: #666; margin-top: 4px;">{{ $item->likes()->count() }}</span>
                    </div>
                @endauth

                <!-- コメント数のアイコンカウンター（見本に合わせ配置） -->
                <div style="display: flex; flex-direction: column; align-items: center; line-height: 1.2;">
                    <span style="font-size: 1.5em; cursor: default;">💬</span>
                    <span style="font-size: 0.75em; color: #666; margin-top: 5px;">{{ $item->comments->count() }}</span>
                </div>

                @guest
                    <span style="font-size: 0.8em; color: #999; margin-left: auto;">※いいねにはログインが必要です</span>
                @endguest
            </div>

            <!-- 🛒 購入ボタンエリア -->
       <div class="purchase-area">
            @if(!$item->is_sold)
                <!-- 💡 フォームではなく、新しく作った購入確認画面へのGETリンクに変更します -->
                <a href="{{ route('item.purchase', $item->id) }}" class="btn-purchase" style="display: block; text-align: center; background-color: #ff4d4f; color: white; text-decoration: none; padding: 14px; font-size: 1.2em; font-weight: bold; border-radius: 4px; cursor: pointer; transition: background 0.2s;">
                    購入手続きへ
                </a>
            @else
                <div class="sold-badge" style="width: 100%; background-color: #e0e0e0; text-align: center; padding: 14px; border-radius: 4px;">
                    <span style="color: #888; font-weight: bold; font-size: 1.2em;">売り切れました</span>
                </div>
            @endif
        </div>


        <!-- 📖 商品説明セクション -->
        <div>
            <h2 style="font-size: 1.3em; font-weight: bold; margin-bottom: 12px; color: #222;">商品説明</h2>
            <p style="white-space: pre-wrap; line-height: 1.7; color: #333; margin: 0;">{{ $item->description }}</p>
        </div>

        <!-- 📋 商品の情報セクション（カテゴリー・状態） -->
        <div>
            <h2 style="font-size: 1.3em; font-weight: bold; margin-bottom: 15px; color: #222;">商品の情報</h2>

            <div style="display: flex; border-bottom: 1px solid #eee; padding: 12px 0; align-items: center;">
                <div style="width: 30%; font-weight: bold; color: #444;">カテゴリー</div>
                <div style="width: 70%; display: flex; gap: 8px; flex-wrap: wrap;">
                    @forelse($item->categories as $category)
                        <span style="background-color: #f0f0f0; padding: 4px 12px; border-radius: 15px; font-size: 0.85em; color: #444;">
                            {{ $category->content ?? $category->name ?? 'カラム名違い' }}
                        </span>
                    @empty
                        <span style="color: #999; font-size: 0.9em;">指定なし</span>
                    @endforelse
                </div>
            </div>

            <div style="display: flex; border-bottom: 1px solid #eee; padding: 12px 0; align-items: center;">
                <div style="width: 30%; font-weight: bold; color: #444;">商品の状態</div>
                <div style="width: 70%; color: #333;">
                    {{ $item->condition->name ?? '設定なし' }}
                </div>
            </div>
        </div>

        <!-- 💬 コメント一覧表示セクション -->
        <div style="margin-top: 10px;">
            <h2 style="font-size: 1.3em; font-weight: bold; margin-bottom: 20px; color: #222;">
                コメント ({{ $item->comments->count() }})
            </h2>

            <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
                @foreach($item->comments as $comment)
                    <div style="padding: 12px 15px; background-color: #f8f9fa; border-radius: 6px; position: relative;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                            <strong style="color: #333; font-size: 0.95em;">{{ $comment->user->name }}様</strong>

                            @if($comment->user_id === $item->user_id)
                                <span style="background-color: #ff4d4f; color: white; padding: 2px 6px; font-size: 0.75em; border-radius: 3px; font-weight: bold;">
                                    出品者
                                </span>
                            @endif

                            <span style="font-size: 0.8em; color: #999; margin-left: auto;">
                                {{ $comment->created_at->format('Y/m/d H:i') }}
                            </span>
                        </div>
                        <p style="margin: 0; white-space: pre-wrap; color: #444; line-height: 1.5; font-size: 0.95em;">{{ $comment->body }}</p>
                    </div>
                @endforeach
            </div>

            <!-- 📝 コメント投稿フォーム -->
            @auth
                <form action="{{ route('comment.store', $item->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <div style="margin-bottom: 12px;">
                        <label for="body" style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">商品へのコメント</label>
                        <textarea name="body" id="body" rows="4" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.95em; box-sizing: border-box;" placeholder="コメントを入力してください" required></textarea>
                    </div>
                    <button type="submit" style="width: 100%; padding: 12px; background-color: #ff4d4f; color: white; border: none; border-radius: 4px; font-weight: bold; font-size: 1em; cursor: pointer;">
                        コメントを送信する
                    </button>
                </form>
            @else
                <p style="color: #888; font-size: 0.9em; text-align: center; background: #f9f9f9; padding: 15px; border-radius: 4px;">
                    ※コメントするには<a href="{{ route('login') }}" style="color: #ff4d4f; text-decoration: none; font-weight: bold;">ログイン</a>が必要です。
                </p>
            @endauth
        </div>

        <!-- 戻るリンク -->
        <div style="text-align: center; margin-top: 10px;">
            <a href="/" style="color: #666; text-decoration: none; font-size: 0.95em;">← 商品一覧に戻る</a>
        </div>

    </div>
</div>
