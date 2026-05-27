@include('layouts.header')

<div style="max-width: 600px; margin: 0 auto; padding: 40px 20px; font-family: sans-serif;">
    <h1 style="text-align: center; font-size: 1.8em; font-weight: bold; margin-bottom: 40px; color: #111;">住所の変更</h1>

    <!-- エラーメッセージの表示エリア -->
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 25px; border: 1px solid #f5c6cb; border-radius: 4px; font-size: 0.95em;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- フォーム送信先は指定の商品IDを含むupdateルート -->
    <form action="{{ route('address.update', $item) }}" method="POST" style="display: flex; flex-direction: column; gap: 30px;">
        @csrf

        <!-- 📮 郵便番号 -->
        <div>
            <label for="postal_code" style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code ?? '') }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.95em; box-sizing: border-box;">
        </div>

        <!-- 🏠 住所 -->
        <div>
            <label for="address" style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address ?? '') }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.95em; box-sizing: border-box;">
        </div>

        <!-- 🏢 建物名 -->
        <div>
            <label for="building" style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $user->building ?? '') }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.95em; box-sizing: border-box;">
        </div>

        <!-- 🚀 更新するボタン -->
        <div style="margin-top: 10px;">
            <button type="submit" style="width: 100%; background-color: #ff4d4f; color: white; border: none; padding: 14px; font-size: 1.1em; font-weight: bold; border-radius: 4px; cursor: pointer; transition: background 0.2s;">
                更新する
            </button>
        </div>
    </form>
</div>
