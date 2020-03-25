<?php 

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Modules\Menu\Models\Menu;

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

$factory->define(Menu::class, function (Faker $faker) {
    $data = [];
         $data['domain_id'] = App\Modules\Structure\Models\Domain::inRandomOrder()->first()->id;
          $data['title'] = $faker->text(60);
          $data['is_active'] = rand(0,1);
          $data['is_sitemap'] = rand(0,1);
         
        
    return $data;
});
