<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Transformers\ContentBlock\Lang;

use App\Modules\ContentBlock\Models\ContentBlock\Photo;
use App\Modules\ContentBlock\Models\ContentBlock\Lang\PhotoLang;
use App\Base\AbstractTransformer;

/**
 * Class PhotoLangTransformer.
 */
class PhotoLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  PhotoLang $photoLang
     * @return  array
     */
    public function transform(PhotoLang $photoLang) : array
    {
        $data = [
            'locale' => $photoLang->locale,
        ];
        
        foreach ((new Photo)->translatedAttributes as $attr) {
            $data[$attr] = $photoLang->$attr;
        }
        
        return $data;
    }    
}
