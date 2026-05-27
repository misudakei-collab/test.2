@include('layouts.header')

<div style="max-width: 600px; margin: 60px auto; padding: 40px 20px; text-align: center; font-family: sans-serif; border: 1px solid #eee; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
    <div style="font-size: 4em; color: #28a745; margin-bottom: 20px;">🎉</div>
    <h1 style="font-size: 1.8em; font-weight: bold; color: #333; margin-bottom: 15px;">ご購入ありがとうございました！</h1>

    <p style="color: #666; line-height: 1.6; margin-bottom: 30px;">
        商品の決済が正常に完了しました。<br>
        出品者からの発送連絡をお待ちください。
    </p>

    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; text-align: left; margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: #444; font-size: 1.1em; border-bottom: 1px solid #ddd; padding-bottom: 8px;">購入内容</h3>
        <p style="margin: 10px 0; color: #333;"><strong>商品名:</strong> {{ $item->name }}</p>
        <p style="margin: 10px 0; color: #333;"><strong>支払金額:</strong> ¥{{ number_format($item->price) }} (クレジットカード決済)</p>
    </div>

    <a href="/" style="display: inline-block; background-color: #ff4d4f; color: white; text-decoration: none; padding: 12px 35px; font-weight: bold; border-radius: 4px; transition: 0.2s;">
        トップページに戻る
    </a>
</div>
