<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Transformers;

use App\Modules\Advantage\Models\Category;
use App\Base\AbstractTransformer;
use App\Modules\Advantage\Transformers\Lang\CategoryLangTransformer;

/**
 * Class CategoryTransformer.
 */
class CategoryTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'is_active',
        'rank',
        'title',
        'description',
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'is_active',
        'rank',
        'title',
        'description',
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'is_active',
        'rank',
        'title',
        'description',
        'lang',
    ];

    /**
     * transform
     *
     * @param  Category $category
     * @return  array
     */
    public function transform(Category $category) : array
    {
        return [
            'id' => $category->id,
        ];
    }    
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Category $category)
    {
   
        return $this->primitive($category->is_active);
        
    }
    
    /**
     * Include rank
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeRank(Category $category)
    {
   
        return $this->primitive($category->rank);
        
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(Category $category)
    {
   
        return $this->primitive($category->title);
        
    }
    
    /**
     * Include description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDescription(Category $category)
    {
   
        return $this->primitive($category->description);
        
    }

    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Category $category)
    {
        return $this->collection($category->translations, new CategoryLangTransformer);
    }
}
