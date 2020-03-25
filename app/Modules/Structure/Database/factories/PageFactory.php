<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Modules\Structure\Services\StructureService;
use App\Modules\Structure\Models\Page;

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

$factory->define(Page::class, function (Faker $faker) {
    $data = [        
        'template_id' => $faker->randomElement(Arr::pluck(StructureService::TEMPLATES, 'id', 'id')), 
        'alias' => $faker->randomElement(['news', 'articles', 'blog', 'about-us', 'contacts']), 
        'is_search' => rand(0,1),
        'is_canonical' => rand(0,1),
        'is_breadcrumbs' => rand(0,1),
        'is_menu' => rand(0,1),
    ];
    
    foreach (config('translatable.locales') as $locale) {
        $data[$locale] = [
            'seo_title' => $faker->text(30),
            'seo_h1' => $faker->text(20),
            'seo_description' => $faker->text(120),
            'breacrumbs_title' => $faker->text(20),
            'head' => $faker->text(200),
        ];
    }
    
    return $data;
});
