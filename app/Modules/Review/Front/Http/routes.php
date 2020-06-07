<?php

Route::name('front.review.')
    ->namespace('\App\Modules\Review\Front\Http\Controllers')
    ->prefix('front/review')
    ->middleware(['front.set.locale'])
    ->group(function () {

	Route::post('send', 'ReviewController@send')->name('send');

});
