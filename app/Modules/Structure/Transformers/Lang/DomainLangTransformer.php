<?php

namespace App\Modules\Structure\Transformers\Lang;

use App\Modules\Structure\Models\Lang\DomainLang;
use App\Modules\Structure\Models\Domain;
use App\Base\AbstractTransformer;

/**
 * Class DomainLangTransformer.
 */
class DomainLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param DomainLang $domainLang
     * @return array
     */
    public function transform(DomainLang $domainLang) : array
    {
        $data = [
            'locale' => $domainLang->locale,
        ];
        
        foreach ((new Domain)->translatedAttributes as $attr) {
            $data[$attr] = $domainLang->$attr;
        }
        
        return $data;
    }    
}
