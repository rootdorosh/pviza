<?php 

Route::name('translation.')
    ->namespace('\App\Modules\Translation\Http\Controllers')
    ->prefix('scms/translation')
    ->middleware('auth:api')
    ->group(function () {


	Route::get('translations/meta', 'TranslationController@meta')->name('translations.meta');
	Route::delete('translations/bulk-destroy', 'TranslationController@bulkDestroy')->name('translations.bulkDestroy');
	Route::apiResource('translations', 'TranslationController');       

});