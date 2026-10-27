<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class ModuleServiceProvider extends ServiceProvider {

    protected $files;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() 
    {
        if(is_dir(app_path().'/Modules/')) {
            $modules = array_map('class_basename', $this->files->directories(app_path().'/Modules/'));
            
            foreach($modules as $module) {   
                if(file_exists(app_path().'/Modules'.'/'.$module.'/routes.php')) {

                    include app_path().'/Modules'.'/'.$module.'/routes.php';
                }

                // Load the views for each of the modules
                if(is_dir(app_path().'/Modules'.'/'.$module.'/Views')) {
                    $this->loadViewsFrom(app_path().'/Modules'.'/'.$module.'/Views', $module);
                }

                
            }
        }



    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() 
    {
        $this->files = new Filesystem;
    }


}