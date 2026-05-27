@include('layouts.header')

<!-- 📦 全体を包むメインコンテナ（左右の2カラム構造） -->
<div style="max-width: 1000px; margin: 0 auto; padding: 40px 20px; display: flex; gap: 60px; font-family: sans-serif;">

    <!-- 1️⃣ 左側カラム：商品情報・支払い方法・配送先（幅60%） -->
    <div style="width: 60%; display: flex; flex-direction: column; gap: 30px;">

        <!-- 商品情報 -->
        <div style="display: flex; gap: 20px; align-items: center; padding-bottom: 30px; border-bottom: 1px solid #ddd;">
            <div style="width: 100px; height: 100px; background-color: #e5e5e5; display: flex; justify-content: center; align-items: center; border-radius: 4px; overflow: hidden; flex-shrink: 0;">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div>
                <h2 style="font-size: 1.5em; font-weight: bold; margin: 0 0 10px 0; color: #111;">{{ $item->name }}</h2>
                <p style="font-size: 1.3em; font-weight: bold; margin: 0; color: #111;">¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <!-- 💳 支払い方法の選択 -->
        <div style="padding-bottom: 30px; border-bottom: 1px solid #ddd;">
            <h3 style="font-size: 1.1em; font-weight: bold; margin-bottom: 15px; color: #333;">支払い方法</h3>
            <div style="position: relative; width: 250px;">
                <!-- 💡 id="payment_select" を指定してJavaScriptで値を監視します -->
                <select name="payment_method" id="payment_select" form="purchase-form" style="width: 100%; border: 1px solid #ccc; border-radius: 4px; padding: 8px 12px; font-size: 0.95em; color: #333; background-color: #fff; appearance: none; -webkit-appearance: none;" onchange="updatePaymentMethod(this)">
                    <option value="">選択してください</option>
                    <option value="card">クレジットカード払い</option>
                    <option value="konbini">コンビニ払い</option>
                </select>
                <div style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); pointer-events: none; color: #666; font-size: 0.8em;">▼</div>
            </div>
        </div>

        <!-- 🏠 配送先エリア -->
        <div style="padding-bottom: 30px; border-bottom: 1px solid #ddd;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="font-size: 1.1em; font-weight: bold; color: #333; margin: 0;">配送先</h3>
                <!-- 💡 住所変更ページ（マイページ等）へのルートをここに指定 -->
                <a href="{{ route('address.edit', $item) }}" style="color: #007bff; text-decoration: none; font-size: 0.95em; font-weight: bold;">変更する</a>
            </div>

            <!-- 💡 ログインユーザーの住所情報をここに自動出力します -->
            <div style="color: #333; line-height: 1.6; padding-left: 20px;">
                <p style="margin: 0 0 5px 0; font-weight: bold;">
                    〒 {{ Auth::user()->postal_code ?? 'XXX-YYYY' }}
                </p>
                <p style="margin: 0; color: #444;">
                    {{ Auth::user()->address ?? 'ここには住所と建物が入ります（未登録）' }}
                </p>
            </div>
        </div>

    </div>

    <!-- 2️⃣ 右側カラム：金額確認ボックス・確定ボタン（幅40%） -->
    <div style="width: 40%; display: flex; flex-direction: column; gap: 20px;">

        <!-- 精算表テーブル -->
        <table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc; background-color: #fff;">
            <tr style="border-bottom: 1px solid #ccc;">
                <td style="padding: 15px; color: #555; font-size: 0.95em;">商品代金</td>
                <td style="padding: 15px; text-align: right; font-weight: bold; font-size: 1.1em; color: #111;">
                    ¥{{ number_format($item->price) }}
                </td>
            </tr>
            <tr>
                <td style="padding: 15px; color: #555; font-size: 0.95em;">支払い方法</td>
                <!-- 💡 id="summary_payment" を指定。JavaScriptで自動テキスト書き換えされます -->
                <td id="summary_payment" style="padding: 15px; text-align: right; font-weight: bold; font-size: 0.95em; color: #111;">
                    選択してください
                </td>
            </tr>
        </table>

        <!-- 🚀 購入確定フォーム -->
        <form action="{{ route('item.checkout', $item) }}" method="POST" id="purchase-form" style="margin: 0;" onsubmit="return validatePayment()">
            @csrf
            <button type="submit" style="width: 100%; background-color: #ff4d4f; color: white; border: none; padding: 14px; font-size: 1.2em; font-weight: bold; border-radius: 4px; cursor: pointer; transition: background 0.2s;">
                購入する
            </button>
        </form>

    </div>
</div>

<!-- 💡 動的なスタイルと入力チェック用のJavaScript -->
<script>
    // プルダウンが選択されたら、右側の精算テーブルの文字を自動で書き換える
    function updatePaymentMethod(select) {
        const summaryText = document.getElementById('summary_payment');

        if (select.value === 'card') {
            summaryText.textContent = 'クレジットカード払い';
        } else if (select.value === 'konbini') {
            summaryText.textContent = 'コンビニ払い';
        } else {
            summaryText.textContent = '選択してください';
        }
    }

    // 購入ボタンを押した際に、支払い方法が未選択なら警告を出す安全対策
    function validatePayment() {
        const select = document.getElementById('payment_select');
        if (select.value === '') {
            alert('支払い方法を選択してください。');
            return false; // 送信をブロック
        }
        return true;
    }
</script>
