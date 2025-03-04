<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TimeZone;
use Carbon\Carbon;

class TimeZoneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $timeZone = TimeZone::where('id',1)->first();
        if($timeZone){
            date_default_timezone_set($timeZone->name);
        config(['app.timezone' => $timeZone->name]);
        }
        else{
            date_default_timezone_set('Asia/Dhaka');
        config(['app.timezone' => 'Asia/Dhaka']);
        }

        // 
        // Carbon::setLocale($timeZone->name);
    }
}
