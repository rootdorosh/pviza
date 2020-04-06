<?php 

namespace App\Modules\Blog\Database\Seeds;

use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {  
       $this->call(CategorySeeder::class);  
       $this->call(BlogSeeder::class);       
    }
}
