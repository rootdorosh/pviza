<?php 

Route::name('review.')
    ->namespace('\App\Modules\Review\Http\Controllers')
    ->prefix('scms/review')
    ->middleware('auth:api')
    ->group(function () {


	Route::get('reviews/meta', 'ReviewController@meta')->name('reviews.meta');
	Route::delete('reviews/bulk-destroy', 'ReviewController@bulkDestroy')->name('reviews.bulkDestroy');
	Route::apiResource('reviews', 'ReviewController')->parameters(['reviews' => 'review']);       

});