<?php

namespace System\Permissions;

use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'permissions');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *  
     * @return void
     */
    public function register()
    {
        $this->app->bind('permission', function($app){
            return new Permissions;
        });
    }
}
