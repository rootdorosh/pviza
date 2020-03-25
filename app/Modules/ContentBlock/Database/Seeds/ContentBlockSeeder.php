<?php 

namespace App\Modules\ContentBlock\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\ContentBlock\Models\ContentBlock;


class ContentBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        factory(ContentBlock::class, 10)->create()->each(function ($contentBlock) {
        
            $contentBlock->photos()
                ->saveMany(factory(\App\Modules\ContentBlock\Models\ContentBlock\Photo::class, 10)->make());
            
        });    
    }
}
