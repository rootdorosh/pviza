<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Blog\Models\Category;
use App\Modules\Blog\Transformers\Lang\CategoryLangTransformer;

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
     * Include image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImage(Category $category)
    {
        return $this->primitive($category->getThumb('image', 100, 75, 'resize'));
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
     * Include alias
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeAlias(Category $category)
    {
        return $this->primitive($category->alias);
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
     * Include seo_h1
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoH1(Category $category)
    {
        return $this->primitive($category->seo_h1);
    }
    
    /**
     * Include seo_title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoTitle(Category $category)
    {
        return $this->primitive($category->seo_title);
    }
    
    /**
     * Include seo_description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoDescription(Category $category)
    {
        return $this->primitive($category->seo_description);
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
