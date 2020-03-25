<?php 

namespace Tests\Feature\Modules\Settings\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Settings\Models\Settings;

/**
 * Class SettingsControllerTest
 * 
 * @group  settings.settings
 */
class SettingsControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Settings $settings
     * @return  array
     */
    private function toArray(Settings $settings): array
    {
        return $settings->toArray();    
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'settings/settings/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'settings/settings/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'settings/settings';
        
		factory(Settings::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'settings/settings/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'settings/settings/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'settings/settings';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'settings/settings/store', 422);   
        
        $data = $this->toArray(factory(Settings::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'settings/settings/store', 201);        
    }
    /**
     * @test
     */
    public function update()
    {       
		$settings = factory(Settings::class)->create(); 
         
        $url = self::BASE_URL . 'settings/settings/' . $settings->id;
        $data = $this->toArray($settings);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'settings/settings/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'settings/settings/update', 200); 
        
        $settings->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'settings/settings/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$settings = factory(Settings::class)->create(); 
         
        $url = self::BASE_URL . 'settings/settings/' . $settings->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'settings/settings/show', 200); 
        
        $settings->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'settings/settings/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$settings = factory(Settings::class)->create(); 
         
        $url = self::BASE_URL . 'settings/settings/' . $settings->id;
        $path = 'settings/settings/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $settings->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$settings = factory(Settings::class)->create(); 
         
        $url = self::BASE_URL . 'settings/settings/bulk-destroy';
        $path = 'settings/settings/bulk_destroy';       
        
        $data = [
            'ids' => [$settings->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
