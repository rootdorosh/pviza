<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Services\Crud;

use App\Modules\Event\Models\Queue;

/**
 * Class QueueCrudService
 */
class QueueCrudService
{

    /*
     *      
     * @param    array $data
     * @return  Queue
     */
    public function store(array $data): Queue
    {
        return Queue::create($data);
	}

    /*
     *      
     * @param    Event $queue
     * @param    Queue $data
     * @return  Queue
     */
    public function update(Queue $queue, array $data): Queue
    {        $queue->update($data);
        
        return $queue;
    }

    /*
     * @param    Queue $queue
     * @return  void
     */
    public function destroy(Queue $queue): void
    {
        $queue->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Queue::destroy($ids);
    }    
  
    
}