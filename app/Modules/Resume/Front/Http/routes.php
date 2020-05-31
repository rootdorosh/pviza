<?php 

Route::name('front.resume.')
    ->namespace('\App\Modules\Resume\Front\Http\Controllers')
    ->prefix('front/resume')
    ->middleware(['front.set.locale'])
    ->group(function () {

	Route::post('send', 'ResumeController@send')->name('send');

});