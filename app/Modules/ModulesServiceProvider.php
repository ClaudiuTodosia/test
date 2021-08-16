<?php
namespace App\Modules;

use Illuminate\Support\Facades\Route;
/**
 * ServiceProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 * @author Kamran Ahmed <kamranahmed.se@gmail.com>
 * @package App\Modules
 */
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */

    public function boot()
    {
        //Fetch the module configuration.
        $config = config('module');

        //Fetch the required module names.
        $modules = $config['modules'];

        foreach($modules as $key => $module) {

            // Load the routes for each of the modules
            if(is_array($module)){

                foreach ($module as $submodule){
                    if(file_exists(__DIR__.'/' . $key . '/Submodules/' . $submodule .'/routes.php')) {
                        require_once __DIR__ . '/' . $key . '/Submodules/' . $submodule . '/routes.php';

                        Route::middleware('web')
                            ->namespace('App\Modules\\' . $key . '\Submodules\\' . $submodule . '\Controllers')
                            ->group(base_path('app/Modules/' . $key . '/Submodules/' . $submodule . '/routes.php'));
                    }

                    // Load the views
                    if(is_dir(__DIR__ . '/' . $key . '/Submodules/' . $submodule . '/Views')) {
                        $this->loadViewsFrom(__DIR__ . '/' . $key . '/Submodules/' . $submodule . '/Views', $submodule);
                    }
                }


            } else {
                if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                    include __DIR__.'/'.$module.'/routes.php';

                    Route::middleware('web')
                        ->namespace('App\Modules\\' . $module . '\Controllers')
                        ->group(base_path('app/Modules/' . $module . '/routes.php'));
                }

                // Load the views
                if(is_dir(__DIR__.'/'.$module.'/Views')) {
                    $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
                }
            }

        }
    }

    public function register() {}

}