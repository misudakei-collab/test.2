@include('layouts.header')

<div style="max-width: 1000px; margin: 0 auto; padding: 40px 20px; font-family: sans-serif;">
    <h1 style="font-size: 1.8em; font-weight: bold; margin-bottom: 30px; color: #111; border-bottom: 2px solid #ff4d4f; padding-bottom: 10px; width: fit-content;">購入した商品</h1>

    @if($items->isEmpty())
        <div style="text-align: center; color: #888; padding: 5px 0; margin-top: 40px;">
            <p style="font-size: 1.2em;">まだ購入した商品はありません</p>
            <a href="/" style="color: #ff4d4f; text-decoration: none; font-weight: bold; font-size: 0.95em;">商品を探しに行く →</a>
        </div>
    @else
        <!-- 商品グリッド一覧 -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px;">
            @foreach($items as $item)
                <!-- 💡 クリックすると売り切れ状態でも詳細画面を開けるリンク -->
                <a href="{{ route('item.show', $item) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div style="background: #fff; border: 1px solid #eee; border-radius: 4px; overflow: hidden; position: relative;">
                        <!-- 商品画像 -->
                        <div style="width: 100%; aspect-ratio: 1 / 1; background-color: #f5f5f5;">
                            <!-- 💡 修正ポイント：image_url をすべて実際のカラム名 image_path に書き換えました -->
                            <img src="{{ str_starts_with($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <!-- SOLDバッジの表示 -->
                        <div style="position: absolute; top: 0; left: 0; width: 0; height: 0; border-top: 50px solid #888; border-right: 50px solid transparent;"></div>
                        <span style="position: absolute; top: 4px; left: 4px; color: #fff; font-size: 9px; font-weight: bold; transform: rotate(-45deg); display: inline-block;">SOLD</span>

                        <!-- 商品情報エリア -->
                        <div style="padding: 10px; display: flex; flex-direction: column; gap: 4px;">
                            <!-- 商品名 -->
                            <p style="margin: 0; font-size: 0.95em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: bold; color: #333;">{{ $item->name }}</p>

                            <!-- 商品の状態（コンディション） -->
                            @if($item->condition)
                                <div style="margin-top: 2px;">
                                    <span style="display: inline-block; background-color: #f0f0f0; color: #666; font-size: 0.75em; padding: 2px 8px; border-radius: 12px; font-weight: 500;">
                                        {{ $item->condition->condition }}
                                    </span>
                                </div>
                            @endif

                            <!-- 価格 -->
                            <p style="margin: 4px 0 0 0; font-weight: bold; color: #ff4d4f; font-size: 1.05em;">¥{{ number_format($item->price) }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
