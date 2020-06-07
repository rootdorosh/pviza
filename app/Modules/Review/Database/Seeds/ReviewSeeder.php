<?php 

namespace App\Modules\Review\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Review\Models\Review;


class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(Review::class, 10)->create()->each(function ($review) {
            
        });    
    }
}
