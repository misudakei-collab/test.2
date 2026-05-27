@include('layouts.header')

<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- ユーザー情報セクション -->
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

    <div style="border-bottom: 1px solid #ddd; margin-bottom: 20px; display: flex; gap: 20px;">
        <a href="{{ route('mypage.index', ['page' => 'sell']) }}" style="text-decoration: none; padding-bottom: 10px; color: {{ $page === 'sell' ? '#ff4d4f' : '#666' }}; border-bottom: {{ $page === 'sell' ? '2px solid #ff4d4f' : 'none' }}; font-weight: {{ $page === 'sell' ? 'bold' : 'normal' }};">
            出品した商品
        </a>
        <a href="{{ route('mypage.index', ['page' => 'buy']) }}" style="text-decoration: none; padding-bottom: 10px; color: {{ $page === 'buy' ? '#ff4d4f' : '#666' }}; border-bottom: {{ $page === 'buy' ? '2px solid #ff4d4f' : 'none' }}; font-weight: {{ $page === 'buy' ? 'bold' : 'normal' }};">
            購入した商品
        </a>
    </div>

    <!-- 商品一覧 -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px;">
        @forelse($items as $item)
            <a href="{{ route('item.show', $item->id) }}" style="text-decoration: none; color: black;">
                <div style="border: 1px solid #eee; border-radius: 8px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $item->image_path) }}" style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                    <div style="padding: 10px;">
                        <p style="margin: 0; font-size: 0.9em; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $item->name }}
                        </p>
                    </div>
                </div>
            </a>
        @empty
            <p style="color: #999;">
                {{ $page === 'buy' ? '購入した商品（いいねした商品）はまだありません。' : '出品した商品はまだありません。' }}
            </p>
        @endforelse
    </div>
</div>
