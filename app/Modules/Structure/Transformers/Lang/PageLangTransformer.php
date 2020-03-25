<?php

namespace App\Modules\Structure\Transformers\Lang;

use App\Modules\Structure\Models\Lang\PageLang;
use App\Modules\Structure\Models\Page;
use App\Base\AbstractTransformer;

/**
 * Class PageLangTransformer.
 */
class PageLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param PageLang $pageLang
     * @return array
     */
    public function transform(PageLang $pageLang) : array
    {
        $data = [
            'locale' => $pageLang->locale,
        ];
        
        foreach ((new Page)->translatedAttributes as $attr) {
            $data[$attr] = $pageLang->$attr;
        }
        
        return $data;
    }    
}
