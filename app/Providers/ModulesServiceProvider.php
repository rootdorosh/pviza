<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use App\Base\ScmsHelper;

class ModulesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        foreach (ScmsHelper::getModules() as $module) {
            $modulePath = app_path() . '/Modules/' . $module . '/';
            
            /*
            if (is_file($modulePath . 'Http/routes.php')) {
                $this->loadRoutesFrom($modulePath . 'Http/routes.php');
            }
            */
            
            //view('module::admin')
            if (is_dir($modulePath . '/Resources/views')) {
                $this->loadViewsFrom($modulePath .  'Resources/views', Str::camel($module));
            }

            if (is_dir($modulePath .  '/Database/migrations')) {
                $this->loadMigrationsFrom($modulePath . '/Database/migrations');
            }
            
            if (is_dir($modulePath . '/Database/factories')) {
                $this->registerEloquentFactoriesFrom($modulePath . '/Database/factories');
            }
        
            //trans('module::messages.welcome')
            if (is_dir($modulePath . '/Resources/lang')) {
                $this->loadTranslationsFrom($modulePath . '/Resources/lang', Str::camel($module));
            }
        }
    }
    
    /**
     * Register factories.
     *
     * @param  string $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom(string $path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }    

    public function register()
    {
        
    }

}
