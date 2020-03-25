<?php 

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Translation\Models\Translation;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Translation::class, function (Faker $faker) {
   $fakerService = resolve('\App\Services\Faker\FakerService');

   $data = [
       'slug' => null,
   ];

   foreach (config('translatable.locales') as $locale) {
       $data[$locale]['value'] = null;
   }

   return $data;
});
