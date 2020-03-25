<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Services\Crud;

use App\Modules\Event\Models\Event;

/**
 * Class EventCrudService
 */
class EventCrudService
{

    /*
     *      
     * @param    array $data
     * @return  Event
     */
    public function store(array $data): Event
    {
        return Event::create($data);
	}

    /*
     *      
     * @param    Event $event
     * @param    Event $data
     * @return  Event
     */
    public function update(Event $event, array $data): Event
    {        $event->update($data);
        
        return $event;
    }

    /*
     * @param    Event $event
     * @return  void
     */
    public function destroy(Event $event): void
    {
        $event->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Event::destroy($ids);
    }    
  
    
}