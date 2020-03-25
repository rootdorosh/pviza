<?php 

namespace App\Modules\Event\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use App\Modules\Event\Models\Event;

/**
 * Class EventFetchService extends FetchService
 */
class EventFetchService
{    
    /**
     * @return  array
     */
    public static function getList(): array
    {
        return Event::get()->pluck('subject', 'id')->toArray();
    }   

    /**
     * @param string $eventId
     * @return Event|null
     */
    public static function getByEventId(string $eventId):? Event
    {
        return Event::where('event_id', $eventId)
            ->where('is_active', 1)
            ->first();
    }   

}


