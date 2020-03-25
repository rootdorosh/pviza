<?php

namespace App\Modules\Structure\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Structure\Models\Page;
use App\Modules\Structure\Transformers\Lang\PageLangTransformer;

/**
 * Class PageTransformer.
 */
class PageTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var array
     */
    protected $defaultIncludes = [
        'title',
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'lang',
        'title',
        'domain_id',
        'template_id',
        'is_search',
        'is_canonical',
        'is_breadcrumbs',
        'is_menu',
        'structure_id',
        'body_class',
    ];

    /**
     * List of item resource to include
     *
     * @var array
     */
    public $itemIncludes = [
        'lang',
        'domain_id',
        'template_id',
        'is_search',
        'is_canonical',
        'is_breadcrumbs',
        'is_menu',
        'structure_id',
        'body_class',
    ];

    /**
     * transform
     *
     * @param Page $page
     * @return array
     */
    public function transform(Page $page) : array
    {
        return [
            'id' => $page->id,
            'alias' => $page->alias,
        ];
    }
    
    /**
     * Include lang
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeLang(Page $page)
    {
        return $this->collection($page->translations, new PageLangTransformer);
    }    
    
    /**
     * Include title
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTitle(Page $page)
    {
        return $this->primitive($page->seo_title);
    }        
    
    /**
     * Include domain_id
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeDomainId(Page $page)
    {
        return $this->primitive($page->domain_id);
    }        
    
    /**
     * Include template_id
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTemplateId(Page $page)
    {
        return $this->primitive($page->template_id);
    }        
    
    /**
     * Include is_search
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeIsSearch(Page $page)
    {
        return $this->primitive($page->is_search);
    }        
    
    /**
     * Include is_canonical
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeIsCanonical(Page $page)
    {
        return $this->primitive($page->is_canonical);
    }        

    /**
     * Include is_breadcrumbs
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeIsBreadcrumbs(Page $page)
    {
        return $this->primitive($page->is_breadcrumbs);
    }        

    /**
     * Include is_menu
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeIsMenu(Page $page)
    {
        return $this->primitive($page->is_menu);
    }          

    /**
     * Include structure_id
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeStructureId(Page $page)
    {
        return $this->primitive($page->structure_id);
    }          

    /**
     * Include body_class
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBodyClass(Page $page)
    {
        return $this->primitive($page->body_class);
    }          
}
