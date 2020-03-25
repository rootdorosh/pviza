<?php 
use Illuminate\Support\Str
?>

Route::name('{{ Str::kebab($moduleName) }}.')
    ->namespace('\App\Modules\{{ $moduleName }}\Http\Controllers')
    ->prefix('scms/{{ Str::kebab($moduleName) }}')
    ->middleware('auth:api')
    ->group(function () {
{!! $content !!}       

});