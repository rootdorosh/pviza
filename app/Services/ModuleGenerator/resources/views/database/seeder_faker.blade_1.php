<?php 
use Illuminate\Support\Str;
?>
namespace App\Modules\<?= $moduleName?>\Database\Seeds;

use Illuminate\Database\Seeder;
use <?= $model['usePath']?>;


class <?= $model['name']?>Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(<?= $model['name']?>::class, <?= $count?>)->create()->each(function (${{ Str::camel($model['name']) }}) {
@foreach ($childrenModels as $childModel)        
            ${{ Str::camel($model['name']) }}->{{ Str::camel($childModel['name_plural']) }}()
                ->saveMany(factory(\{{ $childModel['usePath'] }}::class, 10)->make());
@endforeach            
        });    
    }
}
