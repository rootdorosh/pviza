<?php 

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Advantage\Models\Category;

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

$factory->define(Category::class, function (Faker $faker) {
     $fakerService = resolve('\App\Services\Faker\FakerService');   $data = [];
   $data['is_active'] = rand(0,1);
   $data['rank'] = rand(10,1000);

   foreach (config('translatable.locales') as $locale) {
       $data[$locale]['title'] = $faker->text(50);
       $data[$locale]['description'] = $faker->text(250);
   }

   return $data;
});
