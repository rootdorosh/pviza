<?php 

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Vacancy\Models\Type;

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

$factory->define(Type::class, function (Faker $faker) {
   $fakerService = resolve('\App\Services\Faker\FakerService');

   $data = [
       'is_active' => rand(0,1),
       'rank' => rand(10,1000),
       'image' => $fakerService->imgPath(),
   ];

   foreach (config('translatable.locales') as $locale) {
       $data[$locale]['title'] = $faker->text(50);
       $data[$locale]['alias'] = $faker->word;
       $data[$locale]['description'] = $faker->text(250);
       $data[$locale]['seo_h1'] = $faker->text(80);
       $data[$locale]['seo_title'] = $faker->text(80);
       $data[$locale]['seo_description'] = $faker->text(80);
   }

   return $data;
});
