<?php 

namespace Tests\Feature\Modules\ContentBlockPhoto\Http\Controllers\ContentBlock;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\ContentBlock\Models\ContentBlock\Photo;
use App\Base\ExtArrHelper;

/**
 * Class PhotoControllerTest
 * 
 * @group  contentBlock.contentBlock.photo
 */
class PhotoControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param  Photo $photo
     * @return  array
     */
    private function toArray(Photo $photo): array
    {
        return ExtArrHelper::keyToItems($photo->toArray(), 'translations', 'locale'); 
    }
    
    /**
     * @test
     */
    public function meta()
    {
		$contentBlock = factory(ContentBlock::class)->create();
        $url = self::BASE_URL . 'content-block/content-blocks/' . $contentBlock->id . '/photos/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
		$contentBlock = factory(ContentBlock::class)->create();
        $url = self::BASE_URL . 'content-block/content-blocks/' . $contentBlock->id . '/photos';
        
		$contentBlock->photos()->saveMany(factory(Photo::class, 3)->make());
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
		$contentBlock = factory(ContentBlock::class)->create();
        $url = self::BASE_URL . 'content-block/content-blocks/' . $contentBlock->id . '/photos';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/store', 422);   
        
        $data = $this->toArray(factory(Photo::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/store', 201);        
    }
    
    /**
     * @test
     */
    public function update()
    {       
		$contentBlock = factory(ContentBlock::class)->create();
		$photo = $contentBlock->photos()->save(factory(Photo::class)->make());
         
        $url = self::BASE_URL . 'content-block/content-blocks/' . $contentBlock->id . '/photos/' . $photo->id;
        $data = $this->toArray($photo);
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/update', 422);   
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/update', 200); 
        
        $photo->delete();
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
		$contentBlock = factory(ContentBlock::class)->create();
		$photo = $contentBlock->photos()->save(factory(Photo::class)->make());
         
        $url = self::BASE_URL . 'content-block/content-blocks/' . $contentBlock->id . '/photos/' . $photo->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/show', 200); 
        
        $photo->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, 'content_block/content_blocks/photos/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
		$contentBlock = factory(ContentBlock::class)->create();
		$photo = $contentBlock->photos()->save(factory(Photo::class)->make());
         
        $url = self::BASE_URL . 'content-block/content-blocks/' . $contentBlock->id . '/photos/' . $photo->id;
        $path = 'content_block/content_blocks/photos/destroy';       
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $photo->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, $path, 404);        
    }
    
    /**
     * @test
     */
    public function bulkDestroy()
    {       
		$contentBlock = factory(ContentBlock::class)->create();
		$photo = $contentBlock->photos()->save(factory(Photo::class)->make());
         
        $url = self::BASE_URL . 'content-block/content-blocks/' . $contentBlock->id . '/photos/bulk-destroy';
        $path = 'content_block/content_blocks/photos/bulk_destroy';       
        
        $data = [
            'ids' => [$photo->id],
        ];
        
        $response = $this->json('DELETE', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
    /**
     * @test
     */
    public function sortable()
    {       
		$contentBlock = factory(ContentBlock::class)->create();
		$photo = $contentBlock->photos()->save(factory(Photo::class)->make());
         
        $url = self::BASE_URL . 'content-block/content-blocks/' . $contentBlock->id . '/photos/sortable';
        $path = 'content_block/content_blocks/photos/sortable';       
        
        $data = [
            'ids' => [$photo->id],
        ];
        
        $response = $this->json('PUT', $url, $data, self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, $path, 204); 
        
        $response = $this->json('PUT', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, $path, 422);        
    }
    
}
