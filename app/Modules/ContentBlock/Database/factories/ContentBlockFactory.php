<?php 

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\ContentBlock\Models\ContentBlock;

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

$factory->define(ContentBlock::class, function (Faker $faker) {
   $fakerService = resolve('\App\Services\Faker\FakerService');

   $data = [
       'image' => $fakerService->imgPath(null, 'cb'),
       'name' => $faker->text(120),
       'is_active' => rand(0,1),
       'is_hide_editor' => rand(0,1),
       'adaptive_image' => null,
   ];

   foreach (config('translatable.locales') as $locale) {
       $data[$locale]['title'] = $faker->text(50);
       $data[$locale]['body'] = $faker->text(250);
   }

   return $data;
});
