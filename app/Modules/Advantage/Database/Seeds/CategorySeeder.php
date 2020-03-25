<?php 

namespace App\Modules\Advantage\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Advantage\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Category::class, 5)->create();
    }
}
