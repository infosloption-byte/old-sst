<?php

namespace System\Department;

use Illuminate\Support\ServiceProvider;

class DepartmentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'Department');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *  
     * @return void
     */
    public function register()
    {
        $this->app->bind('Department', function($app){
            return new Department;
        });
    }
}
