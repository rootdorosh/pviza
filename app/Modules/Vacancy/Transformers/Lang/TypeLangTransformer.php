<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Transformers\Lang;

use App\Modules\Vacancy\Models\Type;
use App\Modules\Vacancy\Models\Lang\TypeLang;
use App\Base\AbstractTransformer;

/**
 * Class TypeLangTransformer.
 */
class TypeLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  TypeLang $typeLang
     * @return  array
     */
    public function transform(TypeLang $typeLang) : array
    {
        $data = [
            'locale' => $typeLang->locale,
        ];
        
        foreach ((new Type)->translatedAttributes as $attr) {
            $data[$attr] = $typeLang->$attr;
        }
        
        return $data;
    }    
}
