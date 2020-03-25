<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Vacancy\Models\Type;
use App\Modules\Vacancy\Transformers\Lang\TypeLangTransformer;

/**
 * Class TypeTransformer.
 */
class TypeTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'is_active',
		'rank',
		'image',
		'title',
		'alias'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'lang',
		'is_active',
		'rank',
		'image',
		'title',
		'alias',
		'description',
		'seo_h1',
		'seo_title',
		'seo_description'
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'lang',
		'is_active',
		'rank',
		'image',
		'title',
		'alias',
		'description',
		'seo_h1',
		'seo_title',
		'seo_description'
    ];

    /**
     * transform
     *
     * @param  Type $type
     * @return  array
     */
    public function transform(Type $type) : array
    {
        return [
            'id' => $type->id,
        ];
    }    
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Type $type)
    {
        return $this->primitive($type->is_active);
    }
    
    /**
     * Include rank
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeRank(Type $type)
    {
        return $this->primitive($type->rank);
    }
    
    /**
     * Include image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImage(Type $type)
    {
        return $this->primitive($type->getThumb('image', 100, 75, 'resize'));
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(Type $type)
    {
        return $this->primitive($type->title);
    }
    
    /**
     * Include alias
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeAlias(Type $type)
    {
        return $this->primitive($type->alias);
    }
    
    /**
     * Include description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDescription(Type $type)
    {
        return $this->primitive($type->description);
    }
    
    /**
     * Include seo_h1
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoH1(Type $type)
    {
        return $this->primitive($type->seo_h1);
    }
    
    /**
     * Include seo_title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoTitle(Type $type)
    {
        return $this->primitive($type->seo_title);
    }
    
    /**
     * Include seo_description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoDescription(Type $type)
    {
        return $this->primitive($type->seo_description);
    }
    
    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Type $type)
    {
        return $this->collection($type->translations, new TypeLangTransformer);
    }

}
