<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Transformers\Lang;

use App\Modules\Translation\Models\Translation;
use App\Modules\Translation\Models\Lang\TranslationLang;
use App\Base\AbstractTransformer;

/**
 * Class TranslationLangTransformer.
 */
class TranslationLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  TranslationLang $translationLang
     * @return  array
     */
    public function transform(TranslationLang $translationLang) : array
    {
        $data = [
            'locale' => $translationLang->locale,
        ];
        
        foreach ((new Translation)->translatedAttributes as $attr) {
            $data[$attr] = $translationLang->$attr;
        }
        
        return $data;
    }    
}
