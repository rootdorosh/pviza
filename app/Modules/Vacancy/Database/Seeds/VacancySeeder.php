<?php 

namespace App\Modules\Vacancy\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Vacancy\Models\Vacancy;


class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Vacancy::class, 10)->create()->each(function ($vacancy) {
            
        });    
    }
}
