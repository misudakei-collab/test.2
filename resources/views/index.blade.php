@include('layouts.header')

<!-- 📦 全体を中央に寄せるメインコンテナ -->
<div style="max-width: 1100px; margin: 0 auto; padding: 20px 30px; font-family: sans-serif;">

    <!-- 🔄 タブ切り替え（見本のすっきりしたレイアウトに準拠） -->
    <div style="border-bottom: 1px solid #e5e5e5; margin-bottom: 35px; display: flex; gap: 40px; padding-left: 10px;">
        <!-- おすすめタブ -->
        <a href="{{ route('item.index', ['tab' => 'recommend', 'keyword' => $keyword]) }}"
           style="text-decoration: none; padding-bottom: 12px; color: {{ $tab === 'recommend' ? '#ff4d4f' : '#666' }}; border-bottom: {{ $tab === 'recommend' ? '2px solid #ff4d4f' : 'none' }}; font-weight: bold; font-size: 1.05em; transition: 0.2s;">
            おすすめ
        </a>

        <!-- マイリストタブ -->
        <a href="{{ route('item.index', ['tab' => 'like', 'keyword' => $keyword]) }}"
           style="text-decoration: none; padding-bottom: 12px; color: {{ $tab === 'like' ? '#ff4d4f' : '#666' }}; border-bottom: {{ $tab === 'like' ? '2px solid #ff4d4f' : 'none' }}; font-weight: bold; font-size: 1.05em; transition: 0.2s;">
            マイリスト
        </a>
    </div>

    <!-- 🛍️ 商品一覧グリッド（見本通りの配置・余白にするため display: grid を採用） -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 30px 20px;">
        @forelse ($items as $item)
            <div style="position: relative;">

                <a href="{{ route('item.show', $item->id) }}" style="text-decoration: none; color: inherit; display: block;">

                    <!-- 🖼️ 画像エリア（見本のような綺麗な正方形の枠に統一） -->
                    <div style="position: relative; width: 100%; aspect-ratio: 1 / 1; background-color: #e5e5e5; border-radius: 4px; overflow: hidden; margin-bottom: 10px;">
                        <!-- 商品画像 -->
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s; {{ $item->is_sold ? 'filter: grayscale(40%); opacity: 0.7;' : '' }}">

                        {{-- ログイン中かつお気に入り登録済みの場合は右下に丸いハートを表示 --}}
                        @if(auth()->check() && $item->likedItems->contains(auth()->id()))
                            <div style="position: absolute; bottom: 10px; right: 10px; background-color: rgba(255, 255, 255, 0.9); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.15); font-size: 13px; z-index: 5;">
                                ❤️
                            </div>
                        @endif

                        {{-- 売り切れている場合のみ、画像の上に赤色の「SOLD」ラベルを斜めに重ねるか、左上に表示 --}}
                        @if($item->is_sold)
                            <div style="position: absolute; top: 0; left: 0; background: #ff4d4f; color: white; padding: 4px 10px; font-size: 0.75em; font-weight: bold; border-bottom-right-radius: 4px; z-index: 5;">
                                SOLD
                            </div>
                        @endif
                    </div>

                    <!-- 📝 商品名（文字が長すぎても崩れないように1行で丸める） -->
                    <p style="margin: 0 0 4px 0; font-size: 0.95em; color: #333; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 0 2px;">
                        {{ $item->name }}
                    </p>

                    <!-- 💰 価格表示（見本に合わせて配置） -->
                    <p style="margin: 0; font-weight: bold; font-size: 1.1em; color: #111; padding: 0 2px;">
                        ¥{{ number_format($item->price) }}
                    </p>
                </a>

            </div>
        @empty
            <!-- 商品が1件もない場合のメッセージ表示 -->
            <div style="grid-column: 1 / -1; text-align: center; color: #999; padding: 60px 0;">
                <p style="font-size: 1.1em;">該当する商品はまだありません</p>
            </div>
        @endforelse
    </div>

</div>
