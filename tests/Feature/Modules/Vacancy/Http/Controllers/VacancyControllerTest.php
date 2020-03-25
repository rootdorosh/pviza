<?php 

namespace Tests\Feature\Modules\Vacancy\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Vacancy\Models\Vacancy;
use App\Base\ExtArrHelper;

/**
 * Class VacancyControllerTest
 * 
 * @group  vacancy.vacancy
 */
class VacancyControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Vacancy $vacancy
     * @return  array
     */
    private function toArray(Vacancy $vacancy): array
    {
        return ExtArrHelper::keyToItems($vacancy->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'vacancy/vacancies/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/vacancies/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'vacancy/vacancies';
        
		factory(Vacancy::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/vacancies/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/vacancies/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'vacancy/vacancies';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/vacancies/store', 422);   
        
        $data = $this->toArray(factory(Vacancy::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'vacancy/vacancies/store', 201);        
    }
    /**
     * @test
     */
    public function update()
    {       
		$vacancy = factory(Vacancy::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/vacancies/' . $vacancy->id;
        $data = $this->toArray($vacancy);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'vacancy/vacancies/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'vacancy/vacancies/update', 200); 
        
        $vacancy->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'vacancy/vacancies/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$vacancy = factory(Vacancy::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/vacancies/' . $vacancy->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'vacancy/vacancies/show', 200); 
        
        $vacancy->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'vacancy/vacancies/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$vacancy = factory(Vacancy::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/vacancies/' . $vacancy->id;
        $path = 'vacancy/vacancies/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $vacancy->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$vacancy = factory(Vacancy::class)->create(); 
         
        $url = self::BASE_URL . 'vacancy/vacancies/bulk-destroy';
        $path = 'vacancy/vacancies/bulk_destroy';       
        
        $data = [
            'ids' => [$vacancy->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
