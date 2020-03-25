<?php 

Route::name('event.')
    ->namespace('\App\Modules\Event\Http\Controllers')
    ->prefix('scms/event')
    ->middleware('auth:api')
    ->group(function () {


	Route::get('events/meta', 'EventController@meta')->name('events.meta');
	Route::delete('events/bulk-destroy', 'EventController@bulkDestroy')->name('events.bulkDestroy');
	Route::apiResource('events', 'EventController')->except('store');


	Route::get('queue/meta', 'QueueController@meta')->name('queues.meta');
	Route::delete('queue/bulk-destroy', 'QueueController@bulkDestroy')->name('queues.bulkDestroy');
	Route::apiResource('queue', 'QueueController')->except('update', 'show', 'store');       

});