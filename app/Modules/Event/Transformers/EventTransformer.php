<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Transformers;

use App\Base\AbstractTransformer;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Transformers\Lang\EventLangTransformer;
use App\Modules\Event\Services\EventService;

/**
 * Class EventTransformer.
 */
class EventTransformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var  array
     */
    protected $defaultIncludes = [
        'event_id',
		'is_active',
		'from_email',
		'subject',
		'from_name'
    ];

    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = [
        'lang',
		'event_id',
		'content_type',
		'is_active',
		'from_email',
		'subject',
		'from_name',
		'body',
		'vars',
    ];

    /**
     * List of item resource to include
     *
     * @var  array
     */
    public $itemIncludes = [
        'lang',
		'event_id',
		'content_type',
		'is_active',
		'from_email',
		'subject',
		'from_name',
		'body',
		'vars',
    ];

    /**
     * transform
     *
     * @param  Event $event
     * @return  array
     */
    public function transform(Event $event) : array
    {
        return [
            'id' => $event->id,
        ];
    }    
    
    /**
     * Include event_id
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeEventId(Event $event)
    {
        return $this->primitive($event->event_id);
    }
    
    /**
     * Include content_type
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeContentType(Event $event)
    {
        return $this->primitive($event->content_type);
    }
    
    /**
     * Include is_active
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeIsActive(Event $event)
    {
        return $this->primitive($event->is_active);
    }
    
    /**
     * Include from_email
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeFromEmail(Event $event)
    {
        return $this->primitive($event->from_email);
    }
    
    /**
     * Include subject
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeSubject(Event $event)
    {
        return $this->primitive($event->subject);
    }
    
    /**
     * Include from_name
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeFromName(Event $event)
    {
        return $this->primitive($event->from_name);
    }
    
    /**
     * Include body
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeBody(Event $event)
    {
        return $this->primitive($event->body);
    }
    
    /**
     * Include vars
     *
     * @return  \League\Fractal\Resource\Item
     */
    public function includeVars(Event $event)
    {
        return $this->primitive(EventService::getVars($event->event_id));
    }
    
    /**
     * Include lang
     *
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeLang(Event $event)
    {
        return $this->collection($event->translations, new EventLangTransformer);
    }

}
