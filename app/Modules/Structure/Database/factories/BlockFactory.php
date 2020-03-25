<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Structure\Models\Block;

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

$factory->define(Block::class, function (Faker $faker) {
    return [
        'alias' => $faker->randomElement(['conten1', 'conten2', 'conten3']),
        'content' => $faker->text(50),
    ];
});
