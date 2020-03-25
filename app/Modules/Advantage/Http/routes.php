<?php 

Route::name('advantage.')
    ->namespace('\App\Modules\Advantage\Http\Controllers')
    ->prefix('scms/advantage')
    ->middleware('auth:api')
    ->group(function () {
        
        Route::get('categories/meta', 'CategoryController@meta')->name('categories.meta');
        Route::delete('categories/bulk-destroy', 'CategoryController@bulkDestroy')->name('categories.bulkDestroy');       
Route::apiResource('categories', 'CategoryController');
                
        Route::get('advantages/meta', 'AdvantageController@meta')->name('advantages.meta');
        Route::delete('advantages/bulk-destroy', 'AdvantageController@bulkDestroy')->name('advantages.bulkDestroy');       
Route::apiResource('advantages', 'AdvantageController');
                    
});