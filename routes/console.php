<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Daily Summary Report
Schedule::command('app:send-daily-report-summary')->dailyAt('23:00');
Schedule::command('tokens:Api-Token-Delete')->hourly();


