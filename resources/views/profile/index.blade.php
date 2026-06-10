@include('layouts.header')

<h1>マイページ</h1>

<a href="{{ route('profile.edit') }}">プロフィール編集</a>

<hr>

<h2>購入した商品一覧</h2>
<div class="item-list" style="display: flex; flex-wrap: wrap;">
    @forelse($purchasedItems as $item)
        <div class="item-card" style="margin: 10px; border: 1px solid #ccc; padding: 10px;">
            <img src="{{ asset('storage/' . $item->image_url) }}" width="100">
            <p>{{ $item->name }}</p>
            <p>¥{{ number_format($item->price) }}</p>
        </div>
    @empty
        <p>購入した商品はまだありません。</p>
    @endforelse
</div>
