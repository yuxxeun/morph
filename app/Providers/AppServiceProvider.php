<?php

namespace App\Providers;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\CacheCheck;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\FlareErrorOccurrenceCountCheck;
use Spatie\Health\Checks\Checks\PingCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Health::checks([
            CacheCheck::new(),
            DatabaseCheck::new(),
            DatabaseSizeCheck::new()
                ->failWhenSizeAboveGb(errorThresholdGb: 1.0),
            DebugModeCheck::new()->expectedToBe(true),
            EnvironmentCheck::new()->expectEnvironment('local'),
            FlareErrorOccurrenceCountCheck::new()->warnWhenMoreErrorsReceivedThan(20),
            UsedDiskSpaceCheck::new()
            // PingCheck::new()->url('localhost:8000')->timeout(3)->name('Development Environment')
        ]);
    }

    public function boot(): void
    {
        //
    }
}
