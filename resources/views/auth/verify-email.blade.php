@include('layouts.header')

<div style="max-width: 600px; margin: 50px auto; text-align: center; font-family: sans-serif;">
    <h1>メール認証が必要です</h1>

    @if (session('status') == 'verification-link-sent')
        <div style="color: green; margin-bottom: 20px;">
            新しい認証リンクを登録メールアドレスに送信しました。
        </div>
    @endif

    <p>ご登録ありがとうございます！<br>
    お届けしたメール内のリンクをクリックして、会員登録を完了させてください。</p>

    <p>もしメールが届いていない場合は、下のボタンから再送することができます。</p>

    <div style="margin-top: 30px; display: flex; justify-content: center; gap: 20px;">
        <!-- 再送ボタン -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" style="padding: 10px 20px; cursor: pointer;">
                認証メールを再送する
            </button>
        </form>

        <!-- ログアウトボタン -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: none; border: none; color: blue; text-decoration: underline; cursor: pointer;">
                ログアウト
            </button>
        </form>
    </div>
</div>
