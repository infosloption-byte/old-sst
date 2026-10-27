<?php

namespace System\Employee;

use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'Employee');
        require __DIR__ . '/Http/routes.php';
    }

    /**
     * Register the application services.
     *  
     * @return void
     */
    public function register()
    {
        $this->app->bind('employee', function($app){
            return new Employee;
        });
    }
}
