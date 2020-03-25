<?php

namespace App\Modules\Structure\Front\Services;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Facade extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return 'frontPage';
    }
}
