<?php 

namespace Tests\Feature\Modules\Feedback\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Feedback\Models\Feedback;

/**
 * Class FeedbackControllerTest
 * 
 * @group  feedback.feedback
 */
class FeedbackControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Feedback $feedback
     * @return  array
     */
    private function toArray(Feedback $feedback): array
    {
        return $feedback->toArray();    
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'feedback/feedbacks/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'feedback/feedbacks/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'feedback/feedbacks';
        
		factory(Feedback::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'feedback/feedbacks/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'feedback/feedbacks/index', 422);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$feedback = factory(Feedback::class)->create(); 
         
        $url = self::BASE_URL . 'feedback/feedbacks/' . $feedback->id;
        $path = 'feedback/feedbacks/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $feedback->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$feedback = factory(Feedback::class)->create(); 
         
        $url = self::BASE_URL . 'feedback/feedbacks/bulk-destroy';
        $path = 'feedback/feedbacks/bulk_destroy';       
        
        $data = [
            'ids' => [$feedback->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
