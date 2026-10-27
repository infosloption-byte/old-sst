<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Inquiry;
use App\Modules\AdminToursManage\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // \URL::forceScheme('https');
        
        // $this->app['request']->server->set('HTTPS','on');

        Blade::directive('show', function($menu) {
           return "<?php echo str_is($menu, \Route::currentRouteName()) ? 'active show' : ''?>";
        });
    
        Blade::directive('active', function($menu) {
           return "<?php echo str_is($menu, \Route::currentRouteName()) ? 'current-menu-item' : ''?>";
        }); 

        
        $count = Inquiry::where('status',0)->count();
        \View::share('sidebar_data', ["inquiries"=>$count]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
