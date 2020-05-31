<?php 

namespace App\Modules\Blog\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Blog\Models\Blog;


class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Blog::class, 10)->create()->each(function ($blog) {
            
        });    
    }
}
