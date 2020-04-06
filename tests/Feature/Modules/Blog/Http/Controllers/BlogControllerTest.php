<?php 

namespace Tests\Feature\Modules\Blog\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Blog\Models\Blog;
use App\Base\ExtArrHelper;

/**
 * Class BlogControllerTest
 * 
 * @group  blog.blog
 */
class BlogControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Blog $blog
     * @return  array
     */
    private function toArray(Blog $blog): array
    {
        return ExtArrHelper::keyToItems($blog->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'blog/blogs/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'blog/blogs/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'blog/blogs';
        
		factory(Blog::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'blog/blogs/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'blog/blogs/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'blog/blogs';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'blog/blogs/store', 422);   
        
        $data = $this->toArray(factory(Blog::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'blog/blogs/store', 201);        
    }
    /**
     * @test
     */
    public function update()
    {       
		$blog = factory(Blog::class)->create(); 
         
        $url = self::BASE_URL . 'blog/blogs/' . $blog->id;
        $data = $this->toArray($blog);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'blog/blogs/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'blog/blogs/update', 200); 
        
        $blog->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'blog/blogs/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$blog = factory(Blog::class)->create(); 
         
        $url = self::BASE_URL . 'blog/blogs/' . $blog->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'blog/blogs/show', 200); 
        
        $blog->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'blog/blogs/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$blog = factory(Blog::class)->create(); 
         
        $url = self::BASE_URL . 'blog/blogs/' . $blog->id;
        $path = 'blog/blogs/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $blog->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$blog = factory(Blog::class)->create(); 
         
        $url = self::BASE_URL . 'blog/blogs/bulk-destroy';
        $path = 'blog/blogs/bulk_destroy';       
        
        $data = [
            'ids' => [$blog->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
