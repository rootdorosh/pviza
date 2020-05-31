<?php 

namespace App\Modules\Resume\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Resume\Models\Resume;


class ResumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Resume::class, 10)->create()->each(function ($resume) {
            
        });    
    }
}
