<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログイン - coachtechフリマ</title>
</head>

<body style="margin: 0; background-color: #fff; font-family: sans-serif;">

    @include('layouts.header')

    <!-- 📦 画面中央に要素を配置するコンテナ -->
    <div style="max-width: 450px; margin: 80px auto; padding: 0 20px; box-sizing: border-box;">

        <h1 style="text-align: center; font-size: 1.6em; font-weight: bold; margin-bottom: 40px; color: #111;">ログイン</h1>

        <!-- 💡 エラー全体の表示エリア（バリデーションエラーがあった場合） -->
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 25px; border: 1px solid #f5c6cb; border-radius: 4px; font-size: 0.95em;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 25px;">
            @csrf

            <!-- ✉️ メールアドレス -->
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 12px; font-size: 1em; box-sizing: border-box;">
            </div>

            <!-- 🔒 パスワード -->
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">パスワード</label>
                <input type="password" name="password" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 12px; font-size: 1em; box-sizing: border-box;">
            </div>

            <!-- 🚀 ログインするボタン -->
            <div style="margin-top: 15px;">
                <button type="submit" style="width: 100%; background-color: #ff4d4f; color: white; border: none; padding: 14px; font-size: 1.1em; font-weight: bold; border-radius: 4px; cursor: pointer; transition: background 0.2s;">
                    ログインする
                </button>
            </div>
        </form>

        <!-- 🔗 会員登録画面への導線リンク -->
        <div style="text-align: center; margin-top: 25px;">
            <a href="/register" style="color: #007bff; text-decoration: none; font-size: 0.9em;">会員登録はこちら</a>
        </div>

    </div>
</body>
</html>

