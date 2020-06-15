<?php 

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Feedback\Models\Feedback;

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

$factory->define(Feedback::class, function (Faker $faker) {
   $fakerService = resolve('\App\Services\Faker\FakerService');

   $data = [
       'name' => $faker->word,
       'email' => $faker->email,
       'phone' => 911,
       'message' => $faker->text(120),
       'created_at' => time(),
   ];

   return $data;
});
