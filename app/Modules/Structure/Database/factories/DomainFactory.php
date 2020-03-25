<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Structure\Models\Domain;

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

$factory->define(Domain::class, function (Faker $faker) {
    $data = [
        'is_active' => rand(0,1),
        'alias' => $faker->domainName,
        'site_lang' => $faker->randomElement(config('translatable.locales')),
        'site_langs' => config('translatable.locales'),
    ];
    
    foreach (config('translatable.locales') as $locale) {
        $data[$locale] = [
            'copyright' => 'Copyright: ' . $faker->text('30'),
        ];
    }
    
    return $data;
});
