@include('layouts.header')

<div style="max-width: 600px; margin: 0 auto; padding: 40px 20px; font-family: sans-serif;">
    <h1 style="text-align: center; font-size: 1.8em; font-weight: bold; margin-bottom: 40px; color: #111;">プロフィール設定</h1>

    <!-- 成功・エラーメッセージの表示エリア -->
    @if (session('message'))
        <div style="background-color: #d4edda; color: #155724; padding: 12px; margin-bottom: 25px; border: 1px solid #c3e6cb; border-radius: 4px; font-size: 0.95em;">
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 25px; border: 1px solid #f5c6cb; border-radius: 4px; font-size: 0.95em;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 30px;">
        @csrf

        <!-- 🖼️ プロフィール画像設定エリア（横並びレイアウト） -->
        <div style="display: flex; align-items: center; gap: 30px; margin-bottom: 10px;">
            <!-- 💡 id="avatar-preview" を付与して選択時に画像を即時切り替え -->
            @if($user->image_url)
                <img id="avatar-preview" src="{{ asset('storage/' . $user->image_url) }}" alt="プロフィール画像" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; background-color: #e6e6e6;">
            @else
                <img id="avatar-preview" src="" alt="プロフィール画像" style="display: none; width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                <div id="avatar-placeholder" style="width: 100px; height: 100px; border-radius: 50%; background-color: #e6e6e6; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;"></div>
            @endif

            <div>
                <label for="image" style="display: inline-block; border: 1px solid #ff4d4f; color: #ff4d4f; background: #fff; padding: 6px 16px; border-radius: 4px; font-size: 0.85em; font-weight: bold; cursor: pointer; transition: 0.2s;">
                    画像を選択する
                </label>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png" style="display: none;" onchange="previewAvatar(this)">
                <div id="image-name" style="margin-top: 5px; font-size: 0.8em; color: #666; white-space: nowrap;"></div>
            </div>
        </div>

        <!-- 👤 ユーザー名 -->
        <div>
            <label for="name" style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">ユーザー名</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.95em; box-sizing: border-box;">
        </div>

        <!-- 📮 郵便番号 -->
        <div>
            <label for="postal_code" style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.95em; box-sizing: border-box;">
        </div>

        <!-- 🏠 住所 -->
        <div>
            <label for="address" style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.95em; box-sizing: border-box;">
        </div>

        <!-- 🏢 建物名 -->
        <div>
            <label for="building" style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $user->building) }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 10px; font-size: 0.95em; box-sizing: border-box;">
        </div>

        <!-- 🚀 更新するボタン -->
        <div style="margin-top: 10px;">
            <button type="submit" style="width: 100%; background-color: #ff4d4f; color: white; border: none; padding: 14px; font-size: 1.1em; font-weight: bold; border-radius: 4px; cursor: pointer; transition: background 0.2s;">
                更新する
            </button>
        </div>
    </form>
</div>

<!-- 💡 画像を選択した瞬間に丸枠の画像を差し替えるJavaScript -->
<script>
    function previewAvatar(input) {
        const fileNameArea = document.getElementById('image-name');
        const preview = document.getElementById('avatar-preview');
        const placeholder = document.getElementById('avatar-placeholder');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            // ファイル名を表示
            fileNameArea.textContent = "選択中: " + file.name;

            // 画像ファイルを読み込んで丸枠にセット
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // 画像タグを表示
                if (placeholder) {
                    placeholder.style.display = 'none'; // 未設定時のグレー丸を隠す
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
