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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
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
