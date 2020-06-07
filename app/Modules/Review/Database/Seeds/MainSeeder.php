<?php 

namespace App\Modules\Review\Database\Seeds;

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
       $this->call(ReviewSeeder::class);       
    }
}
