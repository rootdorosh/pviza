<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Transformers\Lang\BlogLangTransformer;

/**
 * Class BlogTransformer.
 */
class BlogTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'category_id',
		'category_title',
		'is_active',
		'is_home',
		'image',
		'created_at',
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
		'category_id',
		'is_active',
		'is_home',
		'image',
		'image_header',
		'created_at',
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
		'category_id',
		'is_active',
		'is_home',
		'image',
		'image_header',
		'created_at',
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
     * @param  Blog $blog
     * @return  array
     */
    public function transform(Blog $blog) : array
    {
        return [
            'id' => $blog->id,
        ];
    }    
    
    /**
     * Include category_id
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCategoryId(Blog $blog)
    {
        return $this->primitive($blog->category_id);
    }
    
    /**
     * Include category_title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCategoryTitle(Blog $blog)
    {
        return $this->primitive($blog->category_title);
    }
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Blog $blog)
    {
        return $this->primitive($blog->is_active);
    }
    
    /**
     * Include is_home
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsHome(Blog $blog)
    {
        return $this->primitive($blog->is_home);
    }
    
    /**
     * Include image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImage(Blog $blog)
    {
        return $this->primitive($blog->getThumb('image', 100, 75, 'resize'));
    }
    
    /**
     * Include image_header
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImageHeader(Blog $blog)
    {
        return $this->primitive($blog->getThumb('image_header', 100, 75, 'resize'));
    }
    
    /**
     * Include created_at
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCreatedAt(Blog $blog)
    {
        return $this->primitive(date('Y-m-d\TH:i:s.0000', $blog->created_at));
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(Blog $blog)
    {
        return $this->primitive($blog->title);
    }
    
    /**
     * Include alias
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeAlias(Blog $blog)
    {
        return $this->primitive($blog->alias);
    }
    
    /**
     * Include description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDescription(Blog $blog)
    {
        return $this->primitive($blog->description);
    }
    
    /**
     * Include seo_h1
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoH1(Blog $blog)
    {
        return $this->primitive($blog->seo_h1);
    }
    
    /**
     * Include seo_title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoTitle(Blog $blog)
    {
        return $this->primitive($blog->seo_title);
    }
    
    /**
     * Include seo_description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSeoDescription(Blog $blog)
    {
        return $this->primitive($blog->seo_description);
    }
    
    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Blog $blog)
    {
        return $this->collection($blog->translations, new BlogLangTransformer);
    }

}
