<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>会員登録 - coachtechフリマ</title>
</head>

<body style="margin: 0; background-color: #fff; font-family: sans-serif;">

    @include('layouts.header')

    <!-- 📦 画面中央に要素を配置するコンテナ -->
    <div style="max-width: 450px; margin: 60px auto; padding: 0 20px; box-sizing: border-box;">

        <h1 style="text-align: center; font-size: 1.6em; font-weight: bold; margin-bottom: 40px; color: #111;">会員登録</h1>

        <form action="/register" method="POST" style="display: flex; flex-direction: column; gap: 25px;">
            @csrf

            <!-- 👤 ユーザー名 -->
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">ユーザー名</label>
                <input type="text" name="name" value="{{ old('name') }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 12px; font-size: 1em; box-sizing: border-box;">
                @error('name')
                    <p style="color: #ff4d4f; font-size: 0.85em; margin: 4px 0 0 0;">{{ $message }}</p>
                @enderror
            </div>

            <!-- ✉️ メールアドレス -->
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 12px; font-size: 1em; box-sizing: border-box;">
                @error('email')
                    <p style="color: #ff4d4f; font-size: 0.85em; margin: 4px 0 0 0;">{{ $message }}</p>
                @enderror
            </div>

            <!-- 🔒 パスワード -->
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">パスワード</label>
                <input type="password" name="password" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 12px; font-size: 1em; box-sizing: border-box;">
                @error('password')
                    <p style="color: #ff4d4f; font-size: 0.85em; margin: 4px 0 0 0;">{{ $message }}</p>
                @enderror
            </div>

            <!-- 🔒 確認用パスワード -->
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #111; font-size: 0.95em;">確認用パスワード</label>
                <input type="password" name="password_confirmation" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 12px; font-size: 1em; box-sizing: border-box;">
            </div>

            <!-- 🚀 登録するボタン -->
            <div style="margin-top: 15px;">
                <button type="submit" style="width: 100%; background-color: #ff4d4f; color: white; border: none; padding: 14px; font-size: 1.1em; font-weight: bold; border-radius: 4px; cursor: pointer; transition: background 0.2s;">
                    登録する
                </button>
            </div>
        </form>

        <!-- 🔗 ログイン画面への導線リンク -->
        <div style="text-align: center; margin-top: 25px;">
            <a href="/login" style="color: #007bff; text-decoration: none; font-size: 0.9em;">ログインはこちら</a>
        </div>

    </div>
</body>
</html>
