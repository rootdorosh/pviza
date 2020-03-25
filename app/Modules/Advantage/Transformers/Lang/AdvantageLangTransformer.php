<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Transformers\Lang;

use App\Modules\Advantage\Models\Lang\AdvantageLang;
use App\Modules\Advantage\Models\Advantage;
use App\Base\AbstractTransformer;

/**
 * Class AdvantageLangTransformer.
 */
class AdvantageLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  AdvantageLang $advantageLang
     * @return  array
     */
    public function transform(AdvantageLang $advantageLang) : array
    {
        $data = [
            'locale' => $advantageLang->locale,
        ];
        
        foreach ((new Advantage)->translatedAttributes as $attr) {
            $data[$attr] = $advantageLang->$attr;
        }
        
        return $data;
    }    
}
