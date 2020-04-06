<?php 

namespace App\Modules\Blog\Database\Seeds;

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
                'title' => 'Все о работе',
                'alias' => 'aaaaaaaaaaaa',
                'is_active' => 1,
            ],
            [
                'title' => 'Все о штрафах',
                'alias' => 'bbbbbbbbbbb',
                'is_active' => 1,
            ],
        ];
        
        (new ImportHelper)->run('\App\Modules\Blog\Models\Category', $data);
    }
}
