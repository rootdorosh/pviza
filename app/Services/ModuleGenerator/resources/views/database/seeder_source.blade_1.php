<?php 
use Illuminate\Support\Str;
?>
namespace App\Modules\<?= $moduleName?>\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Base\ImportHelper;

class <?= $model['name']?>Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {!! $source !!}
        
        (new ImportHelper)->run('\<?= $model['usePath']?>', $data);
    }
}
