<?php 

namespace App\Modules\ContentBlock\Database\Seeds;

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
       $this->call(ContentBlockSeeder::class);       
    }
}
