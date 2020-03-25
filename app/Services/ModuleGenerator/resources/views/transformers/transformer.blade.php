<?php 
use Illuminate\Support\Str;
?>
declare( strict_types = 1 );

namespace {{ $namespace }};

use App\Base\AbstractTransformer;
@foreach ($uses as $use)
use {{ $use }};
@endforeach

/**
 * Class {{ $model['name'] }}Transformer.
 */
class {{ $model['name'] }}Transformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var array
     */
    protected $defaultIncludes = [
        {!! implode(",\n\t\t", array_map(function($value){ return "'{$value}'"; }, $defaultIncludes)) !!}
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        {!! implode(",\n\t\t", array_map(function($value){ return "'{$value}'"; }, $availableIncludes)) !!}
    ];

    /**
     * List of item resource to include
     *
     * @var array
     */
    public $itemIncludes = [
        {!! implode(",\n\t\t", array_map(function($value){ return "'{$value}'"; }, $itemIncludes)) !!}
    ];

    /**
     * transform
     *
     * @param {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return array
     */
    public function transform({{ $model['name'] }} ${{ Str::camel($model['name']) }}) : array
    {
        return [
            'id' => ${{ Str::camel($model['name']) }}->id,
        ];
    }    
<?php foreach ($includesFunction as $item):?>    
    /**
     * Include {{ $item['attr'] }}
     *
     * @return {!! $item['return'] !!}
     */
    public function include<?= ucfirst(Str::camel($item['attr']))?>({{ $model['name'] }} ${{ Str::camel($model['name']) }})
    {
        {!! $item['body'] !!}
    }
<?php endforeach ?>

}
