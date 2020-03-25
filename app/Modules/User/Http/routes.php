<?php

Route::name('user.')
    ->namespace('\App\Modules\User\Http\Controllers')
    ->prefix('scms/user')
    ->middleware('auth:api')
    ->group(function () {
        
        Route::get('users/meta', 'UserController@meta')->name('users.meta');
        Route::post('users/{user}', 'UserController@update')->name('user.update'); 
        Route::delete('users/bulk-destroy', 'UserController@bulkDestroy')->name('users.bulkDestroy');       
        Route::apiResource('users', 'UserController')->except(['update']);    
        
        Route::get('roles/meta', 'RoleController@meta')->name('roles.meta');       
        Route::delete('roles/bulk-destroy', 'RoleController@bulkDestroy')->name('roles.bulkDestroy');       
        Route::apiResource('roles', 'RoleController');        
});