<?php 

namespace Tests\Feature\Modules\Advantage\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Advantage\Models\Advantage;
use App\Base\ExtArrHelper;

/**
 * Class AdvantageControllerTest
 * 
 * @group  advantage
 */
class AdvantageControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Advantage $advantage
     * @return  array
     */
    private function toArray(Advantage $advantage): array
    {
        return ExtArrHelper::keyToItems($advantage->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'advantage/advantages/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'advantage/advantages/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'advantage/advantages';
        
        factory(Advantage::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'advantage/advantages/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'advantage/advantages/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'advantage/advantages';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'advantage/advantages/store', 422);   
        
        $data = $this->toArray(factory(Advantage::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'advantage/advantages/store', 201);        
    }
    
    /**
     * @test
     */
    public function update()
    {       
        $advantage = factory(Advantage::class)->create();
        $url = self::BASE_URL . 'advantage/advantages/' . $advantage->id;
        $data = $this->toArray($advantage);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'advantage/advantages/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'advantage/advantages/update', 200); 
        
        $advantage->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'advantage/advantages/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
        $advantage = factory(Advantage::class)->create();
        $url = self::BASE_URL . 'advantage/advantages/' . $advantage->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'advantage/advantages/show', 200); 
        
        $advantage->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'advantage/advantages/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
        $advantage = factory(Advantage::class)->create();
        $url = self::BASE_URL . 'advantage/advantages/' . $advantage->id;
        $path = 'advantage/advantages/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $advantage->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
        $advantage = factory(Advantage::class)->create();
        $url = self::BASE_URL . 'advantage/advantages/bulk-destroy';
        $path = 'advantage/advantages/bulk_destroy';       
        
        $data = [
            'ids' => [$advantage->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
