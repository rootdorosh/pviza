<?php 

namespace App\Modules\Vacancy\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Base\ImportHelper;

class TypeSeeder extends Seeder
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
                'title' => 'Мясокомбінат',
                'alias' => 'myasokombinat',
                'is_active' => 1,
            ],
            [
                'title' => 'Робота в ресторані',
                'alias' => 'robota-v-restorani',
                'is_active' => 1,
            ],
        ];
        
        (new ImportHelper)->run('\App\Modules\Vacancy\Models\Type', $data);
    }
}
