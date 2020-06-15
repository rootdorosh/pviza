<?php

Route::name('front.feedback.')
    ->namespace('\App\Modules\Feedback\Front\Http\Controllers')
    ->prefix('front/feedback')
    ->middleware(['front.set.locale'])
    ->group(function () {

	Route::post('send', 'FeedbackController@send')->name('send');

});
