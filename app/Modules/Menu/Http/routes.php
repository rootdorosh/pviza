<?php 

Route::name('menu.')
    ->namespace('\App\Modules\Menu\Http\Controllers')
    ->prefix('scms/menu')
    ->middleware('auth:api')
    ->group(function () {
                
        Route::delete('menus/bulk-destroy', 'MenuController@bulkDestroy')->name('menus.bulkDestroy');       
        Route::get('menus/meta', 'MenuController@meta')->name('menus.meta');
        Route::apiResource('menus', 'MenuController');
                    
});