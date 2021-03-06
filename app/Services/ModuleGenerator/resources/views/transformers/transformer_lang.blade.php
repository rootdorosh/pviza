<?php 
use Illuminate\Support\Str;
?>
declare( strict_types = 1 );

namespace {{ $namespace }};

use {{ $model['usePath'] }};
use {{ $modelLangPath }};
use App\Base\AbstractTransformer;

/**
 * Class {{ $model['name'] }}LangTransformer.
 */
class {{ $model['name'] }}LangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param {{ $model['name'] }}Lang ${{ Str::camel($model['name']) }}Lang
     * @return array
     */
    public function transform({{ $model['name'] }}Lang ${{ Str::camel($model['name']) }}Lang) : array
    {
        $data = [
            'locale' => ${{ Str::camel($model['name']) }}Lang->locale,
        ];
        
        foreach ((new {{ $model['name'] }})->translatedAttributes as $attr) {
            $data[$attr] = ${{ Str::camel($model['name']) }}Lang->$attr;
        }
        
        return $data;
    }    
}
