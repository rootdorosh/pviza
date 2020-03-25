<?php

namespace App\Modules\Structure\Front\Services;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    protected $defer = true;

    public function register()
    {
        $this->app->singleton('frontPage', function () {
            return new FrontPage();
        });
    }
    
    public function provides()
    {
        return ['frontPage'];
    }
}
