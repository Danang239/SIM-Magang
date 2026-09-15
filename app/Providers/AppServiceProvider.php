<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (request()->header('x-forwarded-proto') === 'https' || request()->isSecure() || config('app.env') === 'production' || str_contains(request()->getHost(), 'trycloudflare.com') || str_contains(request()->getHost(), 'loca.lt') || str_contains(request()->getHost(), 'pinggy.link')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\PengajuanStatusChanged::class,
            \App\Listeners\RecordPengajuanStatusLog::class
        );
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\PengajuanStatusChanged::class,
            \App\Listeners\SendPengajuanNotifikasi::class
        );
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\PengajuanStatusChanged::class,
            \App\Listeners\SendPengajuanStatusEmail::class
        );
    }
}
