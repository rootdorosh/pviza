<?php 

Route::name('settings.')
    ->namespace('\App\Modules\Settings\Http\Controllers')
    ->prefix('scms/settings')
    ->middleware('auth:api')
    ->group(function () {

	Route::get('settings/meta', 'SettingsController@meta')->name('settings.meta');
	Route::post('settings', 'SettingsController@store')->name('settings.store');

});