<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Transformers\Lang;

use App\Modules\Advantage\Models\Lang\CategoryLang;
use App\Modules\Advantage\Models\Category;
use App\Base\AbstractTransformer;

/**
 * Class CategoryLangTransformer.
 */
class CategoryLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  CategoryLang $categoryLang
     * @return  array
     */
    public function transform(CategoryLang $categoryLang) : array
    {
        $data = [
            'locale' => $categoryLang->locale,
        ];
        
        foreach ((new Category)->translatedAttributes as $attr) {
            $data[$attr] = $categoryLang->$attr;
        }
        
        return $data;
    }    
}
