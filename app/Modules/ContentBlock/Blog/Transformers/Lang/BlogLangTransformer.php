<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Transformers\Lang;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\Lang\BlogLang;
use App\Base\AbstractTransformer;

/**
 * Class BlogLangTransformer.
 */
class BlogLangTransformer extends AbstractTransformer
{
    /**
     * transform
     *
     * @param  BlogLang $blogLang
     * @return  array
     */
    public function transform(BlogLang $blogLang) : array
    {
        $data = [
            'locale' => $blogLang->locale,
        ];
        
        foreach ((new Blog)->translatedAttributes as $attr) {
            $data[$attr] = $blogLang->$attr;
        }
        
        return $data;
    }    
}
