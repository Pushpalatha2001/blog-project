<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command('app:update-user-data', function () {
    $this->call(UpdateUserData::class);
})->describe('Update user data from external API');
