<?php 

namespace Tests\Feature\Modules\Review\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Review\Models\Review;

/**
 * Class ReviewControllerTest
 * 
 * @group  review.review
 */
class ReviewControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Review $review
     * @return  array
     */
    private function toArray(Review $review): array
    {
        return $review->toArray();    
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'review/reviews/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'review/reviews/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'review/reviews';
        
		factory(Review::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'review/reviews/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'review/reviews/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'review/reviews';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'review/reviews/store', 422);   
        
        $data = $this->toArray(factory(Review::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'review/reviews/store', 201);        
    }
    /**
     * @test
     */
    public function update()
    {       
		$review = factory(Review::class)->create(); 
         
        $url = self::BASE_URL . 'review/reviews/' . $review->id;
        $data = $this->toArray($review);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'review/reviews/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'review/reviews/update', 200); 
        
        $review->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'review/reviews/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$review = factory(Review::class)->create(); 
         
        $url = self::BASE_URL . 'review/reviews/' . $review->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'review/reviews/show', 200); 
        
        $review->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'review/reviews/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$review = factory(Review::class)->create(); 
         
        $url = self::BASE_URL . 'review/reviews/' . $review->id;
        $path = 'review/reviews/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $review->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$review = factory(Review::class)->create(); 
         
        $url = self::BASE_URL . 'review/reviews/bulk-destroy';
        $path = 'review/reviews/bulk_destroy';       
        
        $data = [
            'ids' => [$review->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
