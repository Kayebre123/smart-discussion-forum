<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your closure based console
| commands. Each closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Existing application functionality preserved completely
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ⚡ UPGRADE: Automated Background Recovery Task Engine
// Periodically updates the active registry status of accounts that served out their duration penalties
Schedule::call(function () {
    User::where('status', 'blacklisted')
        ->where('blacklist_until', '<=', now())
        ->update([
            'status' => 'active',
            'warnings_count' => 0,
            'blacklist_until' => null
        ]);
})->hourly();