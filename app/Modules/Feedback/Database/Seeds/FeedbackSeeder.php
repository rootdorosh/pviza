<?php 

namespace App\Modules\Feedback\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Feedback\Models\Feedback;


class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Feedback::class, 10)->create()->each(function ($feedback) {
            
        });    
    }
}
