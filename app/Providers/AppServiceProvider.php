<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Basic;
use App\Models\AdminEmail;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $basic = Basic::where('id','1')->first();
        view()->share('basic',$basic);
        
        // Fetch Notification
        $notificAdmin = DB::table('notifications')->count('id');
        view()->share('notificAdmin',$notificAdmin);

        $email = AdminEmail::where('id',1)->first();
        view()->share('emails',$email);
    }
}
