<?php 

namespace Tests\Feature\Modules\Event\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Event\Models\Event;
use App\Base\ExtArrHelper;

/**
 * Class EventControllerTest
 * 
 * @group  event.event
 */
class EventControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Event $event
     * @return  array
     */
    private function toArray(Event $event): array
    {
        return ExtArrHelper::keyToItems($event->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'event/events/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'event/events/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'event/events';
        
		factory(Event::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'event/events/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'event/events/index', 422);        
    }
    /**
     * @test
     */
    public function update()
    {       
		$event = factory(Event::class)->create(); 
         
        $url = self::BASE_URL . 'event/events/' . $event->id;
        $data = $this->toArray($event);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'event/events/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'event/events/update', 200); 
        
        $event->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'event/events/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$event = factory(Event::class)->create(); 
         
        $url = self::BASE_URL . 'event/events/' . $event->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'event/events/show', 200); 
        
        $event->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'event/events/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$event = factory(Event::class)->create(); 
         
        $url = self::BASE_URL . 'event/events/' . $event->id;
        $path = 'event/events/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $event->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$event = factory(Event::class)->create(); 
         
        $url = self::BASE_URL . 'event/events/bulk-destroy';
        $path = 'event/events/bulk_destroy';       
        
        $data = [
            'ids' => [$event->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
