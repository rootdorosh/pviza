<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Vacancy\Models\Location;
use App\Modules\Vacancy\Transformers\Lang\LocationLangTransformer;

/**
 * Class LocationTransformer.
 */
class LocationTransformer extends AbstractTransformer
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
     * @param  Location $location
     * @return  array
     */
    public function transform(Location $location) : array
    {
        return [
            'id' => $location->id,
        ];
    }    
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Location $location)
    {
        return $this->primitive($location->is_active);
    }
    
    /**
     * Include rank
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeRank(Location $location)
    {
        return $this->primitive($location->rank);
    }
    
    /**
     * Include image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImage(Location $location)
    {
        return $this->primitive($location->getThumb('image', 100, 75, 'resize'));
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(Location $location)
    {
        return $this->primitive($location->title);
    }
    
    /**
     * Include alias
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeAlias(Location $location)
    {
        return $this->primitive($location->alias);
    }
    
    /**
     * Include description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDescription(Location $location)
    {
        return $this->primitive($location->description);
    }
    
    /**
     * Include seo_h1
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoH1(Location $location)
    {
        return $this->primitive($location->seo_h1);
    }
    
    /**
     * Include seo_title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoTitle(Location $location)
    {
        return $this->primitive($location->seo_title);
    }
    
    /**
     * Include seo_description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoDescription(Location $location)
    {
        return $this->primitive($location->seo_description);
    }
    
    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Location $location)
    {
        return $this->collection($location->translations, new LocationLangTransformer);
    }

}
