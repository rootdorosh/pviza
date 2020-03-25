<?php 

namespace Tests\Feature\Modules\Location\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Vacancy\Models\Location;
use App\Base\ExtArrHelper;

/**
 * Class LocationControllerTest
 * 
 * @group  vacancy.location
 */
class LocationControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Location $location
     * @return  array
     */
    private function toArray(Location $location): array
    {
        return ExtArrHelper::keyToItems($location->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'vacancy/locations/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/locations/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'vacancy/locations';
        
		factory(Location::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/locations/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/locations/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'vacancy/locations';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/locations/store', 422);   
        
        $data = $this->toArray(factory(Location::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'vacancy/locations/store', 201);        
    }
    /**
     * @test
     */
    public function update()
    {       
		$location = factory(Location::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/locations/' . $location->id;
        $data = $this->toArray($location);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/locations/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'vacancy/locations/update', 200); 
        
        $location->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'vacancy/locations/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$location = factory(Location::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/locations/' . $location->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/locations/show', 200); 
        
        $location->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'vacancy/locations/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$location = factory(Location::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/locations/' . $location->id;
        $path = 'vacancy/locations/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $location->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$location = factory(Location::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/locations/bulk-destroy';
        $path = 'vacancy/locations/bulk_destroy';       
        
        $data = [
            'ids' => [$location->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
