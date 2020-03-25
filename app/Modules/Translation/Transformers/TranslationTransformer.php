<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Translation\Models\Translation;
use App\Modules\Translation\Transformers\Lang\TranslationLangTransformer;

/**
 * Class TranslationTransformer.
 */
class TranslationTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'slug',
		'value'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'lang',
		'slug',
		'value'
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'lang',
		'slug',
		'value'
    ];

    /**
     * transform
     *
     * @param  Translation $translation
     * @return  array
     */
    public function transform(Translation $translation) : array
    {
        return [
            'id' => $translation->id,
        ];
    }    
    
    /**
     * Include slug
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSlug(Translation $translation)
    {
        return $this->primitive($translation->slug);
    }
    
    /**
     * Include value
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeValue(Translation $translation)
    {
        return $this->primitive($translation->value);
    }
    
    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Translation $translation)
    {
        return $this->collection($translation->translations, new TranslationLangTransformer);
    }

}
