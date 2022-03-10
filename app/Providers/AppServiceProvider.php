<?php

namespace App\Providers;

use App\Admin;
use App\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

//use Illuminate\Support\Facades\Gate;
//use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->registerPolicies();
//        $user = \Auth::user();
//
//        // Auth gates for: Admin panel
//        Gate::define('admin_panel', function ($user) {
//            return in_array($user->role_id, [1,2]);
//        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
    }
}
