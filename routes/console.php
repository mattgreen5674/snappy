<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:countries-import')
    ->dailyAt('01:00')
    ->environments('production');

Schedule::command('app:players-import')
    ->everyOddHour() // May need to consider if this is too much or too little!
    ->unlessBetween('23:55', '0:05')
    ->environments('production');
