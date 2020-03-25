<?php 

namespace App\Modules\Vacancy\Database\Seeds;

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
       $this->call(TypeSeeder::class);  
       $this->call(LocationSeeder::class);  
       $this->call(VacancySeeder::class);       
    }
}
