<?php 

namespace Tests\Feature\Modules\Resume\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Resume\Models\Resume;

/**
 * Class ResumeControllerTest
 * 
 * @group  resume.resume
 */
class ResumeControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Resume $resume
     * @return  array
     */
    private function toArray(Resume $resume): array
    {
        return $resume->toArray();    
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'resume/resumes/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'resume/resumes/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'resume/resumes';
        
		factory(Resume::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'resume/resumes/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'resume/resumes/index', 422);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$resume = factory(Resume::class)->create(); 
         
        $url = self::BASE_URL . 'resume/resumes/' . $resume->id;
        $path = 'resume/resumes/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $resume->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$resume = factory(Resume::class)->create(); 
         
        $url = self::BASE_URL . 'resume/resumes/bulk-destroy';
        $path = 'resume/resumes/bulk_destroy';       
        
        $data = [
            'ids' => [$resume->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
