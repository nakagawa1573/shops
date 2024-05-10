<?php

namespace App\Providers;

use App\Models\Evaluation;
use App\Models\Reservation;
use App\Models\Shop;
use App\Policies\EvaluationPolicy;
use App\Policies\ReservationPolicy;
use App\Policies\ShopPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Reservation::class => ReservationPolicy::class,
        Shop::class => ShopPolicy::class,
        Evaluation::class => EvaluationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('確認用メール')
                ->greeting('お知らせ')
                ->line('下のボタンをクリックして認証を完了させてください。')
                ->action('こちらをクリック', $url);
        });
    }
}
