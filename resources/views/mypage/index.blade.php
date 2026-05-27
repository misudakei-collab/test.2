<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ - coachtechフリマ</title>
</head>
<body style="margin: 0; background-color: #fff; font-family: sans-serif;">

    @include('layouts.header')

    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <!-- 👤 ユーザー情報セクション -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px;">
            <div style="display: flex; align-items: center;">
                @if(auth()->user()->image_url)
                    <img src="{{ asset('storage/' . auth()->user()->image_url) }}" alt="プロフィール画像" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-right: 15px;">
                @else
                    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #ccc; display: flex; align-items: center; justify-content: center; color: white; margin-right: 15px;">
                        No Image
                    </div>
                @endif
                <h2>{{ auth()->user()->name }}様のマイページ</h2>
            </div>

            <!-- プロフィール編集ボタン -->
            <a href="{{ route('profile.edit') }}" style="padding: 8px 16px; border: 1px solid #ff4d4f; color: #ff4d4f; text-decoration: none; border-radius: 4px;">
                プロフィールを編集
            </a>
        </div>

        <!-- 🔄 タブ切り替えエリア（お気に入りタブを完璧に合流！） -->
        <div style="border-bottom: 1px solid #ddd; margin-bottom: 20px; display: flex; gap: 20px;">
            <a href="{{ route('mypage.index', ['page' => 'sell']) }}" style="text-decoration: none; padding-bottom: 10px; color: {{ $page === 'sell' ? '#ff4d4f' : '#666' }}; border-bottom: {{ $page === 'sell' ? '2px solid #ff4d4f' : 'none' }}; font-weight: {{ $page === 'sell' ? 'bold' : 'normal' }};">
                出品した商品
            </a>
            <a href="{{ route('mypage.index', ['page' => 'buy']) }}" style="text-decoration: none; padding-bottom: 10px; color: {{ $page === 'buy' ? '#ff4d4f' : '#666' }}; border-bottom: {{ $page === 'buy' ? '2px solid #ff4d4f' : 'none' }}; font-weight: {{ $page === 'buy' ? 'bold' : 'normal' }};">
                購入した商品
            </a>
            <!-- 💡 新しく「お気に入りした商品」への切り替えタブを追加しました -->
            <a href="{{ route('mypage.index', ['page' => 'like']) }}" style="text-decoration: none; padding-bottom: 10px; color: {{ $page === 'like' ? '#ff4d4f' : '#666' }}; border-bottom: {{ $page === 'like' ? '2px solid #ff4d4f' : 'none' }}; font-weight: {{ $page === 'like' ? 'bold' : 'normal' }};">
                お気に入りした商品
            </a>
        </div>

        <!-- 🛍️ 商品一覧 -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px;">
            @forelse($items as $item)
                <a href="{{ route('item.show', $item->id) }}" style="text-decoration: none; color: black;">
                    <div style="border: 1px solid #eee; border-radius: 8px; overflow: hidden; position: relative;">
                        <!-- 💡 修正：ネット上のURL（httpから始まる）か、ローカル画像（storage/）かを自動判別してここでも表示！ -->
                        <img src="{{ str_starts_with($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path) }}" style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">

                        {{-- 売り切れている場合の「SOLD」バッジ表示 --}}
                        @if($item->is_sold)
                            <div style="position: absolute; top: 0; left: 0; background: #ff4d4f; color: white; padding: 2px 8px; font-size: 0.75em; font-weight: bold; border-bottom-right-radius: 4px;">
                                SOLD
                            </div>
                        @endif

                        <div style="padding: 10px;">
                            <p style="margin: 0; font-size: 0.9em; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $item->name }}
                            </p>
                            <!-- 価格も表示させると見やすくなります -->
                            <p style="margin: 4px 0 0 0; font-weight: bold; font-size: 0.95em; color: #111;">
                                ¥{{ number_format($item->price) }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <!-- 💡 選択しているタブに応じてメッセージを3パターンに完全に最適化 -->
                <p style="color: #999;">
                    @if($page === 'buy')
                        購入した商品はまだありません。
                    @elseif($page === 'like')
                        お気に入りした商品はまだありません。
                    @else
                        出品した商品はまだありません。
                    @endif
                </p>
            @endforelse
        </div>
    </div>

</body>
</html>
