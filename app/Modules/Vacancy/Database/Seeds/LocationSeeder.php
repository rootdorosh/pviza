<?php 

namespace App\Modules\Vacancy\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Base\ImportHelper;

class LocationSeeder extends Seeder
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
                'title' => 'Катовіце',
                'alias' => 'katovitse',
                'is_active' => 1,
            ],
            [
                'title' => 'Варшава',
                'alias' => 'varshava',
                'is_active' => 1,
            ],
        ];
        
        (new ImportHelper)->run('\App\Modules\Vacancy\Models\Location', $data);
    }
}
