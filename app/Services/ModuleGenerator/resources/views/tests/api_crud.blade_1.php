<?php 
use Illuminate\Support\Str;
?>
namespace {{ $namespace }};

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
@if (!empty($model['parentModel']))
use App\Modules\{{ $moduleName }}\Models\{{ $model['parentModel'] }};
@endif
use {{ $model['usePath'] }};
@if (!empty($model['translatable']))
use App\Base\ExtArrHelper;
@endif

/**
 * Class {{ $model['name'] }}ControllerTest
 * 
 * @group {{ $group }}
 */
class {{ $model['name'] }}ControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return array
     */
    private function toArray({{ $model['name'] }} ${{ Str::camel($model['name']) }}): array
    {
@if (!empty($model['translatable']))
        return ExtArrHelper::keyToItems(${{ Str::camel($model['name']) }}->toArray(), 'translations', 'locale'); 
@else
        return ${{ Str::camel($model['name']) }}->toArray();    
@endif
    }
    
    /**
     * @test
     */
    public function meta()
    {
{!! $parentModelFactory !!}        $url = self::BASE_URL . '{!! $routeIndex !!}/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, '{{ $responsePath }}/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
{!! $parentModelFactory !!}        $url = self::BASE_URL . '{!! $routeIndex !!}';
        
{!! $indexFactoryItems !!}        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, '{{ $responsePath }}/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, '{{ $responsePath }}/index', 422);        
    }
@if ($model['uiStore'])    
    /**
     * @test
     */
    public function store()
    {
{!! $parentModelFactory !!}        $url = self::BASE_URL . '{!! $routeIndex !!}';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, '{{ $responsePath }}/store', 422);   
        
        $data = $this->toArray(factory({{ $model['name'] }}::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, '{{ $responsePath }}/store', 201);        
    }
@endif
@if ($model['uiUpdate'])
    /**
     * @test
     */
    public function update()
    {       
{!! $parentModelFactory !!}{!! $modelFactory !!}         
        $url = self::BASE_URL . '{!! $routeUpdate !!};
        $data = $this->toArray(${{ Str::camel($model['name']) }});
        
        $response = $this->json('{{ $updateMethod }}', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, '{{ $responsePath }}/update', 422);   
        
        $response = $this->json('{{ $updateMethod }}', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, '{{ $responsePath }}/update', 200); 
        
        ${{ Str::camel($model['name']) }}->delete();
        
        $response = $this->json('{{ $updateMethod }}', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, '{{ $responsePath }}/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
{!! $parentModelFactory !!}{!! $modelFactory !!}         
        $url = self::BASE_URL . '{!! $routeUpdate !!};
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, '{{ $responsePath }}/show', 200); 
        
        ${{ Str::camel($model['name']) }}->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, '{{ $responsePath }}/show', 404);        
    }
@endif    
    /**
     * @test
     */
    public function destroy()
    {       
{!! $parentModelFactory !!}{!! $modelFactory !!}         
        $url = self::BASE_URL . '{!! $routeUpdate !!};
        $path = '{{ $responsePath }}/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        ${{ Str::camel($model['name']) }}->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
{!! $parentModelFactory !!}{!! $modelFactory !!}         
        $url = self::BASE_URL . '{!! $routeIndex !!}/bulk-destroy';
        $path = '{{ $responsePath }}/bulk_destroy';       
        
        $data = [
            'ids' => [${{ Str::camel($model['name']) }}->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
<?php if (!empty($model['parentModel'])):?>    
    /**
     * @test
     */
    public function sortable()
    {       
{!! $parentModelFactory !!}{!! $modelFactory !!}         
        $url = self::BASE_URL . '{!! $routeIndex !!}/sortable';
        $path = '{{ $responsePath }}/sortable';       
        
        $data = [
            'ids' => [${{ Str::camel($model['name']) }}->id],
        ];
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
<?php endif;?>    
}
