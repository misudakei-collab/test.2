<header style="display: flex; justify-content: space-between; align-items: center; padding: 15px 30px; background-color: #000; color: #fff;">
    <!-- ロゴ・サービス名 -->
    <a href="/" style="color: #fff; text-decoration: none; font-size: 1.5em; font-weight: bold;">
        COACHTECH
    </a>

    <form action="{{ route('item.index') }}" method="GET" class="flex items-center" style="margin: 0;">
    <input
        type="text"
        name="keyword"
        value="{{ request('keyword') }}"
        placeholder="なにをお探しですか？"
        class="border rounded px-3 py-1 w-64 text-sm"
        style="color: #000; width: 300px; padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.9em;"
    >
</form>

    <!-- ナビゲーション -->
    <nav>
        <ul style="display: flex; list-style: none; gap: 20px; margin: 0; align-items: center;">
            @auth
                <!-- ログイン中のみ表示 -->
                <li><a href="/mypage" style="color: #fff; text-decoration: none;">マイページ</a></li>
                <li><a href="/sell" style="color: #fff; text-decoration: none;">出品</a></li>
                <li>
                    <!-- ログアウトボタン -->
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #fff; cursor: pointer; font-size: 1em; padding: 0;">
                            ログアウト
                        </button>
                    </form>
                </li>
            @else
                <!-- 未ログイン時のみ表示 -->
                <li><a href="/login" style="color: #fff; text-decoration: none;">ログイン</a></li>
                <li><a href="/register" style="color: #fff; text-decoration: none;">会員登録</a></li>
            @endauth
        </ul>
    </nav>
</header>
