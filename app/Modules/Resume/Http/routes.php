<?php 

Route::name('resume.')
    ->namespace('\App\Modules\Resume\Http\Controllers')
    ->prefix('scms/resume')
    ->middleware('auth:api')
    ->group(function () {


	Route::get('resumes/meta', 'ResumeController@meta')->name('resumes.meta');
	Route::delete('resumes/bulk-destroy', 'ResumeController@bulkDestroy')->name('resumes.bulkDestroy');
	Route::apiResource('resumes', 'ResumeController')
		->parameters(['resumes' => 'resume'])
		->except('update', 'store');       

});