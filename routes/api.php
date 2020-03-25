<?php

use Illuminate\Http\Request;
use App\Base\ScmsHelper;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
        'middleware' => ['cors'],
    ], function ($router) {
    
    foreach (ScmsHelper::getModules() as $module) {
        $file = app_path() . '/Modules/' . $module . '/Http/routes.php';
        if (is_file($file)) {
            include $file;
        }
    }
    
    
});