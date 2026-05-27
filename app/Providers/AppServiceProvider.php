<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail; // ←これを上部に追加
use Illuminate\Notifications\Messages\MailMessage; // ←これも上部に追加

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ↓ここから追記
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('【フリマアプリ】会員登録を完了してください')
                ->greeting($notifiable->name . '様')
                ->line('この度はフリマアプリにご登録いただき、誠にありがとうございます。')
                ->line('以下のボタンをクリックして、メールアドレスの認証を完了させてください。')
                ->action('メールアドレスを認証する', $url)
                ->line('もしこのメールに心当たりがない場合は、破棄してください。');
        });
        // ↑ここまで追記
    }
}
