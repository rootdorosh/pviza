<?php 

Route::name('blog.')
    ->namespace('\App\Modules\Blog\Http\Controllers')
    ->prefix('scms/blog')
    ->middleware('auth:api')
    ->group(function () {


	Route::get('categories/meta', 'CategoryController@meta')->name('categories.meta');
	Route::delete('categories/bulk-destroy', 'CategoryController@bulkDestroy')->name('categories.bulkDestroy');
	Route::apiResource('categories', 'CategoryController')->parameters(['categories' => 'category']);


	Route::get('blogs/meta', 'BlogController@meta')->name('blogs.meta');
	Route::delete('blogs/bulk-destroy', 'BlogController@bulkDestroy')->name('blogs.bulkDestroy');
	Route::apiResource('blogs', 'BlogController')->parameters(['blogs' => 'blog']);       

});