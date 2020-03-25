<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\ContentBlock\Transformers\Lang\ContentBlockLangTransformer;

/**
 * Class ContentBlockTransformer.
 */
class ContentBlockTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'image',
		'name',
		'is_active',
		'is_hide_editor',
		'title'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'lang',
		'image',
		'name',
		'is_active',
		'is_hide_editor',
		'adaptive_image',
		'title',
		'body'
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'lang',
		'image',
		'name',
		'is_active',
		'is_hide_editor',
		'adaptive_image',
		'title',
		'body'
    ];

    /**
     * transform
     *
     * @param  ContentBlock $contentBlock
     * @return  array
     */
    public function transform(ContentBlock $contentBlock) : array
    {
        return [
            'id' => $contentBlock->id,
        ];
    }    
    
    /**
     * Include image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImage(ContentBlock $contentBlock)
    {
        return $this->primitive($contentBlock->getThumb('image', 100, 75, 'resize'));
    }
    
    /**
     * Include name
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeName(ContentBlock $contentBlock)
    {
        return $this->primitive($contentBlock->name);
    }
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(ContentBlock $contentBlock)
    {
        return $this->primitive($contentBlock->is_active);
    }
    
    /**
     * Include is_hide_editor
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsHideEditor(ContentBlock $contentBlock)
    {
        return $this->primitive($contentBlock->is_hide_editor);
    }
    
    /**
     * Include adaptive_image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeAdaptiveImage(ContentBlock $contentBlock)
    {
        $data = (array) $contentBlock->adaptive_image;
        $data = array_filter($data, function($item) {
            return is_array($item);
        });
        
        return $this->primitive(array_dot($data));
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(ContentBlock $contentBlock)
    {
        return $this->primitive($contentBlock->title);
    }
    
    /**
     * Include body
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeBody(ContentBlock $contentBlock)
    {
        return $this->primitive($contentBlock->body);
    }
    
    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(ContentBlock $contentBlock)
    {
        return $this->collection($contentBlock->translations, new ContentBlockLangTransformer);
    }

}
