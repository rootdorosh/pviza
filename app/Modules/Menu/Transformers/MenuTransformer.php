<?php 

declare( strict_types = 1 );

namespace App\Modules\Menu\Transformers;

use App\Modules\Menu\Models\Menu;
use App\Base\AbstractTransformer;

/**
 * Class MenuTransformer.
 */
class MenuTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'title',
        'is_active',
        'is_sitemap',
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'domain_id',
        'title',
        'is_active',
        'is_sitemap',
        'items',
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'domain_id',
        'title',
        'is_active',
        'is_sitemap',
        'items',
    ];

    /**
     * transform
     *
     * @param  Menu $menu
     * @return  array
     */
    public function transform(Menu $menu) : array
    {
        return [
            'id' => $menu->id,
        ];
    }    
    
    /**
     * Include domain_id
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDomainId(Menu $menu)
    {
        return $this->primitive($menu->domain_id);
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(Menu $menu)
    {
        return $this->primitive($menu->title);
    }
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Menu $menu)
    {
        return $this->primitive($menu->is_active);
    }
    
    /**
     * Include is_sitemap
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsSitemap(Menu $menu)
    {
        return $this->primitive($menu->is_sitemap);
    }

    /**
     * Include items
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeItems(Menu $menu)
    {
        return $this->primitive($menu->items);
    }

}
