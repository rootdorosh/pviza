<?php 

namespace Tests\Feature\Modules\Advantage\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Advantage\Models\Category;
use App\Base\ExtArrHelper;

/**
 * Class CategoryControllerTest
 * 
 * @group  advantage
 */
class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Category $category
     * @return  array
     */
    private function toArray(Category $category): array
    {
        return ExtArrHelper::keyToItems($category->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'advantage/categories/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'advantage/categories/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'advantage/categories';
        
        factory(Category::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'advantage/categories/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'advantage/categories/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'advantage/categories';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'advantage/categories/store', 422);   
        
        $data = $this->toArray(factory(Category::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'advantage/categories/store', 201);        
    }
    
    /**
     * @test
     */
    public function update()
    {       
        $category = factory(Category::class)->create();
        $url = self::BASE_URL . 'advantage/categories/' . $category->id;
        $data = $this->toArray($category);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'advantage/categories/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'advantage/categories/update', 200); 
        
        $category->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'advantage/categories/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
        $category = factory(Category::class)->create();
        $url = self::BASE_URL . 'advantage/categories/' . $category->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'advantage/categories/show', 200); 
        
        $category->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'advantage/categories/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
        $category = factory(Category::class)->create();
        $url = self::BASE_URL . 'advantage/categories/' . $category->id;
        $path = 'advantage/categories/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $category->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
        $category = factory(Category::class)->create();
        $url = self::BASE_URL . 'advantage/categories/bulk-destroy';
        $path = 'advantage/categories/bulk_destroy';       
        
        $data = [
            'ids' => [$category->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
