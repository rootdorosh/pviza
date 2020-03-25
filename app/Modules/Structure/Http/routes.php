<?php

Route::name('structure.')
    ->namespace('\App\Modules\Structure\Http\Controllers')
    ->prefix('scms/structure')
    ->middleware('auth:api')
    ->group(function () {
        
        Route::get('domains/meta', 'DomainController@meta')->name('domains.meta');       
        Route::delete('domains/bulk-destroy', 'DomainController@bulkDestroy')->name('domains.bulkDestroy');       
        Route::apiResource('domains', 'DomainController');  

        Route::get('domains/pages/meta', 'PageController@meta')->name('pages.meta');       
        Route::apiResource('domains/{domain}/pages', 'PageController');
        Route::post('domains/{domain}/pages/{page}/move', 'PageController@move')->name('pages.move');    
        Route::post('domains/{domain}/pages/{page}/copy', 'PageController@copy')->name('pages.copy');    
        
        Route::get('domains/blocks/meta', 'BlockController@meta')->name('blocks.meta');    
        Route::get('domains/{domain}/pages/{page}/blocks/{alias}', 'BlockController@show')->name('blocks.show');    
        Route::get('domains/{domain}/pages/{page}/blocks', 'BlockController@index')->name('blocks.index');    
        Route::delete('domains/{domain}/pages/{page}/blocks/{alias}', 'BlockController@destroy')->name('blocks.destroy'); 
        Route::post('domains/{domain}/pages/{page}/blocks', 'BlockController@insert')->name('blocks.insert');
});     