<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Transformers\Lang;

use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\ContentBlock\Models\Lang\ContentBlockLang;
use App\Base\AbstractTransformer;

/**
 * Class ContentBlockLangTransformer.
 */
class ContentBlockLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  ContentBlockLang $contentBlockLang
     * @return  array
     */
    public function transform(ContentBlockLang $contentBlockLang) : array
    {
        $data = [
            'locale' => $contentBlockLang->locale,
        ];
        
        foreach ((new ContentBlock)->translatedAttributes as $attr) {
            $data[$attr] = $contentBlockLang->$attr;
        }
        
        return $data;
    }    
}
