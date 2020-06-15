<?php 

Route::name('feedback.')
    ->namespace('\App\Modules\Feedback\Http\Controllers')
    ->prefix('scms/feedback')
    ->middleware('auth:api')
    ->group(function () {


	Route::get('feedbacks/meta', 'FeedbackController@meta')->name('feedbacks.meta');
	Route::delete('feedbacks/bulk-destroy', 'FeedbackController@bulkDestroy')->name('feedbacks.bulkDestroy');
	Route::apiResource('feedbacks', 'FeedbackController')
		->parameters(['feedbacks' => 'feedback'])
		->except('update', 'store');       

});