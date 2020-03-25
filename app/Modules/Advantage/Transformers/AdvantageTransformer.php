<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Transformers;

use App\Modules\Advantage\Models\Advantage;
use App\Base\AbstractTransformer;
use App\Modules\Advantage\Transformers\Lang\AdvantageLangTransformer;

/**
 * Class AdvantageTransformer.
 */
class AdvantageTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'category_id',
        'category_title',
        'image',
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
        'category_id',
        'image',
        'is_active',
        'rank',
        'svg_code',
        'title',
        'description',
        'body',
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'category_id',
        'image',
        'is_active',
        'rank',
        'svg_code',
        'title',
        'description',
        'body',
        'lang',
    ];

    /**
     * transform
     *
     * @param  Advantage $advantage
     * @return  array
     */
    public function transform(Advantage $advantage) : array
    {
        return [
            'id' => $advantage->id,
        ];
    }    
    
    /**
     * Include category_id
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCategoryId(Advantage $advantage)
    {
   
        return $this->primitive($advantage->category->id);
        
    }
    
    /**
     * Include category_title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCategoryTitle(Advantage $advantage)
    {
   
        return $this->primitive($advantage->category->title);
        
    }
    
    /**
     * Include image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImage(Advantage $advantage)
    {
    
        return $this->primitive($advantage->getThumb('image', 100, 75, 'crop'));
        
    }
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Advantage $advantage)
    {
   
        return $this->primitive($advantage->is_active);
        
    }
    
    /**
     * Include rank
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeRank(Advantage $advantage)
    {
   
        return $this->primitive($advantage->rank);
        
    }
    
    /**
     * Include svg_code
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSvgCode(Advantage $advantage)
    {
   
        return $this->primitive($advantage->svg_code);
        
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(Advantage $advantage)
    {
   
        return $this->primitive($advantage->title);
        
    }
    
    /**
     * Include description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDescription(Advantage $advantage)
    {
   
        return $this->primitive($advantage->description);
        
    }
    
    /**
     * Include body
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeBody(Advantage $advantage)
    {
   
        return $this->primitive($advantage->body);
        
    }

    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Advantage $advantage)
    {
        return $this->collection($advantage->translations, new AdvantageLangTransformer);
    }
}
