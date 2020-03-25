<?php 

Route::name('vacancy.')
    ->namespace('\App\Modules\Vacancy\Http\Controllers')
    ->prefix('scms/vacancy')
    ->middleware('auth:api')
    ->group(function () {


	Route::get('categories/meta', 'CategoryController@meta')->name('categories.meta');
	Route::delete('categories/bulk-destroy', 'CategoryController@bulkDestroy')->name('categories.bulkDestroy');
	Route::apiResource('categories', 'CategoryController');


	Route::get('types/meta', 'TypeController@meta')->name('types.meta');
	Route::delete('types/bulk-destroy', 'TypeController@bulkDestroy')->name('types.bulkDestroy');
	Route::apiResource('types', 'TypeController');


	Route::get('locations/meta', 'LocationController@meta')->name('locations.meta');
	Route::delete('locations/bulk-destroy', 'LocationController@bulkDestroy')->name('locations.bulkDestroy');
	Route::apiResource('locations', 'LocationController');


	Route::get('vacancies/meta', 'VacancyController@meta')->name('vacancies.meta');
	Route::delete('vacancies/bulk-destroy', 'VacancyController@bulkDestroy')->name('vacancies.bulkDestroy');
	Route::apiResource('vacancies', 'VacancyController');       

});