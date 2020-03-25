<?php 

namespace Tests\Feature\Modules\Menu\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\Menu\Models\Menu;

/**
 * Class MenuControllerTest
 * 
 * @group  menu
 */
class MenuControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Menu $menu
     * @return  array
     */
    private function toArray(Menu $menu): array
    {
            return $menu->toArray();    
                }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . 'menu/menus/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'menu/menus/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . 'menu/menus';
        
        factory(Menu::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'menu/menus/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'menu/menus/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . 'menu/menus';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'menu/menus/store', 422);   
        
        $data = $this->toArray(factory(Menu::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'menu/menus/store', 201);        
    }
    
    /**
     * @test
     */
    public function update()
    {       
        $menu = factory(Menu::class)->create();
        $url = self::BASE_URL . 'menu/menus/' . $menu->id;
        $data = $this->toArray($menu);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'menu/menus/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'menu/menus/update', 200); 
        
        $menu->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'menu/menus/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
        $menu = factory(Menu::class)->create();
        $url = self::BASE_URL . 'menu/menus/' . $menu->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'menu/menus/show', 200); 
        
        $menu->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'menu/menus/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
        $menu = factory(Menu::class)->create();
        $url = self::BASE_URL . 'menu/menus/' . $menu->id;
               
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, 'menu/menus/destroy', 204); 
        
        $menu->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'menu/menus/destroy', 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
        $menu = factory(Menu::class)->create();
        $url = self::BASE_URL . 'menu/menus/bulk-destroy';
        $path = 'menu/menus/bulk_destroy';
        
        $data = [
            'ids' => [$menu->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
