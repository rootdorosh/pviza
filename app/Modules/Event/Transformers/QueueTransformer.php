<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Event\Models\Queue;

/**
 * Class QueueTransformer.
 */
class QueueTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'event_id',
		'event_subject',
		'from_email',
		'from_name',
		'email_to',
		'subject',
		'body',
		'status',
		'created_time',
		'sended_time'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'event_id',
		'status',
		'from_email',
		'from_name',
		'email_to',
		'subject',
		'body',
		'created_time',
		'sended_time',
		'status',
	];

    /**
     * transform
     *
     * @param  Queue $queue
     * @return  array
     */
    public function transform(Queue $queue) : array
    {
        return [
            'id' => $queue->id,
        ];
    }    
    
    /**
     * Include event_id
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeEventId(Queue $queue)
    {
        return $this->primitive($queue->event_id);
    }
    
    /**
     * Include status
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeStatus(Queue $queue)
    {
        return $this->primitive($queue->getStatusTitle());
    }
    
    /**
     * Include event_subject
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeEventSubject(Queue $queue)
    {
        return $this->primitive($queue->event_subject);
    }
        
    /**
     * Include from_email
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeFromEmail(Queue $queue)
    {
        return $this->primitive($queue->from_email);
    }
    
    /**
     * Include from_name
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeFromName(Queue $queue)
    {
        return $this->primitive($queue->from_name);
    }
    
    /**
     * Include email_to
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeEmailTo(Queue $queue)
    {
        return $this->primitive($queue->email_to);
    }
    
    /**
     * Include subject
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSubject(Queue $queue)
    {
        return $this->primitive($queue->subject);
    }
    
    /**
     * Include body
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeBody(Queue $queue)
    {
        return $this->primitive($queue->body);
    }
    
    /**
     * Include created_time
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeCreatedTime(Queue $queue)
    {
        return $this->primitive(
            $queue->created_time 
                ? date(config('scms.datetime_format'), $queue->created_time)
                : null
        );
    }
    
    /**
     * Include sended_time
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSendedTime(Queue $queue)
    {
        return $this->primitive(
            $queue->datetime_format 
                ? date(config('scms.datetime_format'), $queue->datetime_format)
                : null
        );
    }
    
}
