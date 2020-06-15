<?php 

namespace App\Modules\Feedback\Database\Seeds;

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
       $this->call(FeedbackSeeder::class);       
    }
}
