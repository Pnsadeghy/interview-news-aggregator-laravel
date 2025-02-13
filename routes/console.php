<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\Schedule;

Schedule::job(function () {
    (new \App\Jobs\FetchNewsFromSourceJob())->handle();
})->everySecond();
