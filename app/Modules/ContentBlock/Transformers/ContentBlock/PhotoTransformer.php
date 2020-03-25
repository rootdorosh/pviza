<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Transformers\ContentBlock;

use App\Base\AbstractTransformer;
use App\Modules\ContentBlock\Models\ContentBlock\Photo;
use App\Modules\ContentBlock\Transformers\ContentBlock\Lang\PhotoLangTransformer;

/**
 * Class PhotoTransformer.
 */
class PhotoTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'image',
		'is_active',
		'rank',
		'title',
		'description'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'lang',
		'image',
		'is_active',
		'type',
		'rank',
		'title',
		'description'
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'lang',
		'image',
		'is_active',
		'type',
		'rank',
		'title',
		'description'
    ];

    /**
     * transform
     *
     * @param  Photo $photo
     * @return  array
     */
    public function transform(Photo $photo) : array
    {
        return [
            'id' => $photo->id,
        ];
    }    
    
    /**
     * Include image
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeImage(Photo $photo)
    {
        return $this->primitive($photo->getThumb('image', 100, 75, 'resize'));
    }
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Photo $photo)
    {
        return $this->primitive($photo->is_active);
    }
    
    /**
     * Include type
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeType(Photo $photo)
    {
        return $this->primitive($photo->type);
    }
    
    /**
     * Include rank
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeRank(Photo $photo)
    {
        return $this->primitive($photo->rank);
    }
    
    /**
     * Include title
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeTitle(Photo $photo)
    {
        return $this->primitive($photo->title);
    }
    
    /**
     * Include description
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeDescription(Photo $photo)
    {
        return $this->primitive($photo->description);
    }
    
    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Photo $photo)
    {
        return $this->collection($photo->translations, new PhotoLangTransformer);
    }

}
