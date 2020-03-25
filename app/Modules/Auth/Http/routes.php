<?php

Route::name('auth.')
    ->namespace('\App\Modules\Auth\Http\Controllers')
    ->prefix('scms/auth')
    ->group(function () {
        
        Route::post('login', 'LoginController')->name('login');
        Route::post('remind-password/email', 'RemindPasswordController@email')->name('remind_password.email');
        Route::post('remind-password/input', 'RemindPasswordController@input')->name('remind_password.input');
        Route::get('logout', 'LogoutController')->middleware('auth:api')->name('logout');
});