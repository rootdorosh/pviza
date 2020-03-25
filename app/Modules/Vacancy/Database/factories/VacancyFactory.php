<?php 

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Vacancy\Models\Vacancy;

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

$factory->define(Vacancy::class, function (Faker $faker) {
   $fakerService = resolve('\App\Services\Faker\FakerService');

   $data = [
       'is_active' => rand(0,1),
       'is_popular' => rand(0,1),
       'rank' => rand(10,1000),
       'date_posted' => null,
       'hiring_organization' => null,
       'image' => $fakerService->imgPath(),
   ];

   foreach (config('translatable.locales') as $locale) {
       $data[$locale]['title'] = $faker->text(50);
       $data[$locale]['alias'] = $faker->word;
       $data[$locale]['salary'] = $faker->text(50);
       $data[$locale]['work_schedule'] = $faker->text(50);
       $data[$locale]['contract_type'] = $faker->text(50);
       $data[$locale]['description'] = $faker->text(200);
       $data[$locale]['seo_h1'] = $faker->text(80);
       $data[$locale]['seo_title'] = $faker->text(80);
       $data[$locale]['seo_description'] = $faker->text(80);
   }

   return $data;
});
