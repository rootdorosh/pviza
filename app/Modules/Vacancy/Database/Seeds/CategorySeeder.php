<?php 

namespace App\Modules\Vacancy\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Base\ImportHelper;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'Для жінок',
                'alias' => 'for-women',
                'is_active' => 1,
            ],
            [
                'title' => 'Для чоловіків',
                'alias' => 'for-men',
                'is_active' => 1,
            ],
        ];
        
        (new ImportHelper)->run('\App\Modules\Vacancy\Models\Category', $data);
    }
}
