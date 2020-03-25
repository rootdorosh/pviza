<?php 

namespace Tests\Feature\Modules\Translation\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Translation\Models\Translation;
use App\Base\ExtArrHelper;

/**
 * Class TranslationControllerTest
 * 
 * @group  translation.translation
 */
class TranslationControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Translation $translation
     * @return  array
     */
    private function toArray(Translation $translation): array
    {
        return ExtArrHelper::keyToItems($translation->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'translation/translations/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'translation/translations/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'translation/translations';
        
		factory(Translation::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'translation/translations/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'translation/translations/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'translation/translations';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'translation/translations/store', 422);   
        
        $data = $this->toArray(factory(Translation::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'translation/translations/store', 201);        
    }
    /**
     * @test
     */
    public function update()
    {       
		$translation = factory(Translation::class)->create(); 
         
        $url = self::BASE_URL . 'translation/translations/' . $translation->id;
        $data = $this->toArray($translation);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'translation/translations/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'translation/translations/update', 200); 
        
        $translation->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'translation/translations/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$translation = factory(Translation::class)->create(); 
         
        $url = self::BASE_URL . 'translation/translations/' . $translation->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'translation/translations/show', 200); 
        
        $translation->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'translation/translations/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$translation = factory(Translation::class)->create(); 
         
        $url = self::BASE_URL . 'translation/translations/' . $translation->id;
        $path = 'translation/translations/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $translation->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$translation = factory(Translation::class)->create(); 
         
        $url = self::BASE_URL . 'translation/translations/bulk-destroy';
        $path = 'translation/translations/bulk_destroy';       
        
        $data = [
            'ids' => [$translation->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
