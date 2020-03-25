<?php 

Route::name('content-block.')
    ->namespace('\App\Modules\ContentBlock\Http\Controllers')
    ->prefix('scms/content-block')
    ->middleware('auth:api')
    ->group(function () {


	Route::get('content-blocks/meta', 'ContentBlockController@meta')->name('content-blocks.meta');
	Route::delete('content-blocks/bulk-destroy', 'ContentBlockController@bulkDestroy')->name('content-blocks.bulkDestroy');
	Route::apiResource('content-blocks', 'ContentBlockController');


	Route::name('content-blocks.')
		->namespace('ContentBlock')
		->prefix('content-blocks/{content_block}')
		->group(function () {
			Route::get('photos/meta', 'PhotoController@meta')->name('photos.meta');
			Route::put('photos/sortable', 'PhotoController@sortable')->name('photos.sortable');
			Route::delete('photos/bulk-destroy', 'PhotoController@bulkDestroy')->name('photos.bulkDestroy');
			Route::apiResource('photos', 'PhotoController');
	});       

});