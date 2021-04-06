<?php

namespace App\Providers;

use App\CoachApplication;
use App\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        if (Schema::hasTable('settings')) {
            View::share('setting', Setting::find(1));
        }

        if (Schema::hasTable('coach_applications')) {
            View::share('pending_coach_applications', CoachApplication::whereStatus(1)->count());
        }
    }
}
