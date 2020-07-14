<?php

use App\Base\ScmsHelper;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('flush', function() {
    \Cache::flush();
    (new \App\Modules\User\Database\Seeds\UsersTableSeeder())->run();
});

Route::group([
        'middleware' => [],
    ], function ($router) {

    foreach (ScmsHelper::getModules() as $module) {
        $file = app_path() . '/Modules/' . $module . '/Front/Http/routes.php';
        if (is_file($file)) {
            include $file;
        }
    }
});


Route::get('/', function() {

    return (new \App\Modules\Structure\Services\StructureService)->renderPage('/');
});

Route::any('{uri}', function($uri) {
    return (new \App\Modules\Structure\Services\StructureService)->renderPage($uri);
})->where('uri', '^(?!api).*$');

