<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('bookings:cancel-stale')->everyFiveSeconds();
Schedule::command('billing:process')->everyFiveSeconds();
Schedule::command('rentform:complete-and-create-reviews')->everyFiveSeconds();

// Schedule::command('app:test-job')->everySecond();