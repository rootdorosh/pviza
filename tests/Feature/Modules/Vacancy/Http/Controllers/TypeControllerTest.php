<?php 

namespace Tests\Feature\Modules\Type\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Vacancy\Models\Type;
use App\Base\ExtArrHelper;

/**
 * Class TypeControllerTest
 * 
 * @group  vacancy.type
 */
class TypeControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Type $type
     * @return  array
     */
    private function toArray(Type $type): array
    {
        return ExtArrHelper::keyToItems($type->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'vacancy/types/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/types/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'vacancy/types';
        
		factory(Type::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/types/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/types/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'vacancy/types';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/types/store', 422);   
        
        $data = $this->toArray(factory(Type::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'vacancy/types/store', 201);        
    }
    /**
     * @test
     */
    public function update()
    {       
		$type = factory(Type::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/types/' . $type->id;
        $data = $this->toArray($type);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/types/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'vacancy/types/update', 200); 
        
        $type->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'vacancy/types/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$type = factory(Type::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/types/' . $type->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/types/show', 200); 
        
        $type->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'vacancy/types/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$type = factory(Type::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/types/' . $type->id;
        $path = 'vacancy/types/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $type->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$type = factory(Type::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/types/bulk-destroy';
        $path = 'vacancy/types/bulk_destroy';       
        
        $data = [
            'ids' => [$type->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
