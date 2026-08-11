<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily automatic status transitions and overdue reminders
\Illuminate\Support\Facades\Schedule::command('app:proses-transisi-status-pengajuan')->daily();

// Scheduled Queue Worker for Shared Hosting (exits when empty to conserve resources)
\Illuminate\Support\Facades\Schedule::command('queue:work --stop-when-empty')
    ->everyMinute()
    ->withoutOverlapping();
