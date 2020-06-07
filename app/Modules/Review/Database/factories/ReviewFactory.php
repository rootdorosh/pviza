<?php 

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Review\Models\Review;

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

$factory->define(Review::class, function (Faker $faker) {
   $fakerService = resolve('\App\Services\Faker\FakerService');

   $data = [
       'is_active' => rand(0,1),
       'is_home' => rand(0,1),
       'created_at' => time(),
       'name' => $faker->word,
       'email' => $faker->email,
       'comment' => $faker->text(200),
   ];

   return $data;
});
