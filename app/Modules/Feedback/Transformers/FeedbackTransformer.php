<?php 

declare( strict_types = 1 );

namespace App\Modules\Feedback\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Feedback\Models\Feedback;

/**
 * Class FeedbackTransformer.
 */
class FeedbackTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'name',
		'email',
		'phone',
		'created_at'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'name',
		'email',
		'phone',
		'message',
		'created_at'
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'name',
		'email',
		'phone',
		'message',
		'created_at'
    ];

    /**
     * transform
     *
     * @param  Feedback $feedback
     * @return  array
     */
    public function transform(Feedback $feedback) : array
    {
        return [
            'id' => $feedback->id,
        ];
    }    
    
    /**
     * Include name
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeName(Feedback $feedback)
    {
        return $this->primitive($feedback->name);
    }
    
    /**
     * Include email
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeEmail(Feedback $feedback)
    {
        return $this->primitive($feedback->email);
    }
    
    /**
     * Include phone
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includePhone(Feedback $feedback)
    {
        return $this->primitive($feedback->phone);
    }
    
    /**
     * Include message
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeMessage(Feedback $feedback)
    {
        return $this->primitive($feedback->message);
    }
    
    /**
     * Include created_at
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCreatedAt(Feedback $feedback)
    {
        return $this->primitive(
			$feedback->created_at
				? date(config('scms.datetime_format'), $feedback->created_at)
				: null
		);

    }

}
