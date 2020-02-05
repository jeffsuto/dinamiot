<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Device;
use App\Observers\DeviceObserver;
use App\Models\Activity;
use App\Observers\ActivityObserver;
use App\Models\Component;
use App\Observers\ComponentObserver;
use App\Models\Value;
use App\Observers\ValueObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Device::observe(DeviceObserver::class);
        Activity::observe(ActivityObserver::class);
        Component::observe(ComponentObserver::class);
        Value::observe(ValueObserver::class);
    }
}
