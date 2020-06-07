<?php 

declare( strict_types = 1 );

namespace App\Modules\Review\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Review\Models\Review;

/**
 * Class ReviewTransformer.
 */
class ReviewTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'is_active',
		'is_home',
		'created_at',
		'name',
		'email',
		'comment'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'is_active',
		'is_home',
		'created_at',
		'name',
		'email',
		'comment'
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'is_active',
		'is_home',
		'created_at',
		'name',
		'email',
		'comment'
    ];

    /**
     * transform
     *
     * @param  Review $review
     * @return  array
     */
    public function transform(Review $review) : array
    {
        return [
            'id' => $review->id,
        ];
    }    
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Review $review)
    {
        return $this->primitive($review->is_active);
    }
    
    /**
     * Include is_home
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsHome(Review $review)
    {
        return $this->primitive($review->is_home);
    }
    
    /**
     * Include created_at
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCreatedAt(Review $review)
    {
        return $this->primitive(
			$review->created_at
				? datetime_to_ui($review->created_at)
				: null
		);

    }
    
    /**
     * Include name
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeName(Review $review)
    {
        return $this->primitive($review->name);
    }
    
    /**
     * Include email
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeEmail(Review $review)
    {
        return $this->primitive($review->email);
    }
    
    /**
     * Include comment
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeComment(Review $review)
    {
        return $this->primitive($review->comment);
    }

}
