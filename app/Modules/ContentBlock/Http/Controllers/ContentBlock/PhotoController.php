<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Http\Controllers\ContentBlock;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\ContentBlock\Models\ContentBlock\Photo;
use App\Modules\ContentBlock\Http\Requests\ContentBlock\Photo\{
    MetaRequest,
	IndexRequest,
	FormRequest,
	ShowRequest,
	DestroyRequest,
	BulkDestroyRequest,
	SortableRequest
};
use App\Services\Response\FractalManager;
use App\Modules\ContentBlock\Transformers\ContentBlock\PhotoTransformer;
use App\Modules\ContentBlock\Services\Crud\ContentBlock\PhotoCrudService;
use App\Modules\ContentBlock\Services\Fetch\ContentBlock\PhotoFetchService;


/**
 * @group  CONTENT_BLOCK
 */
class PhotoController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  PhotoTransformer
     */
    private $transformer;
    
    /**
     * @var  PhotoCrudService
     */
    private $crudService;
    
    /**
     * @var  PhotoFetchService
     */
    private $fetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  PhotoTransformer $transformer
    * @param  PhotoCrudService $crudService
    * @param  PhotoFetchService $fetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        PhotoTransformer $transformer,    
        PhotoCrudService $crudService,    
        PhotoFetchService $fetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;        
    }
    
    /**
     * ContentBlock photos meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/content_block/content_blocks/photos/meta/200.json
     *      
     * @param      ContentBlock $contentBlock     
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(ContentBlock $contentBlock, MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('contentBlock::content_block_photo'),
			'model' => [
				'fields' => [
					'image' => [
						'type' => 'image',
						'required' => false,
					],
					'is_active' => [
						'type' => 'checkbox',
						'required' => true,
						'default' => 1,
					],
					'type' => [
						'type' => 'select',
						'required' => false,
						'options' => ExtArrHelper::valueTextFromList(PHOTO::TYPES),
					],
				],
				'translatable' => [
					'title' => [
						'type' => 'input',
						'required' => true,
					],
					'description' => [
						'type' => 'ckeditor',
						'required' => false,
					],
				],
				],
		]);
    }

    /**
     * ContentBlock photos list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/content_block/content_blocks/photos/index/200.json
     * @responseFile  422 responses/content_block/content_blocks/photos/index/422.json
     *      
     * @param      ContentBlock $contentBlock     
     * @param      IndexRequest $request
     * @return    JsonResponse
     */
    public function index(ContentBlock $contentBlock, IndexRequest $request): JsonResponse
    {
        return response()->json($this->fractalManager->collectionToFractal(
            $this->fetchService->getData($contentBlock),
            $this->transformer
        ));
    }

    /**
     * ContentBlock photos store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/content_block/content_blocks/photos/store/201.json
     * @responseFile  422 responses/content_block/content_blocks/photos/store/422.json
     *      
     * @param      ContentBlock $contentBlock     
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(ContentBlock $contentBlock, FormRequest $request): JsonResponse
    {
        $photo = $this->crudService->store($contentBlock, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($photo, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * ContentBlock photos update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/content_block/content_blocks/photos/update/200.json
     * @responseFile  422 responses/content_block/content_blocks/photos/update/422.json
     * @responseFile  404 responses/content_block/content_blocks/photos/update/404.json
     *      
     * @param      ContentBlock $contentBlock     
     * @param      Photo $photo
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(ContentBlock $contentBlock, Photo $photo, FormRequest $request): JsonResponse
    {
        $photo = $this->crudService->update($contentBlock, $photo, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($photo, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * ContentBlock photos show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/content_block/content_blocks/photos/show/200.json
     * @responseFile  422 responses/content_block/content_blocks/photos/show/404.json
     *      
     * @param      ContentBlock $contentBlock     
     * @param      Photo $photo
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(ContentBlock $contentBlock, Photo $photo, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($photo, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }

    /**
     * ContentBlock photos destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/content_block/content_blocks/photos/destroy/204.json
     * @responseFile  422 responses/content_block/content_blocks/photos/destroy/404.json
     *      
     * @param      ContentBlock $contentBlock     
     * @param      Photo $photo
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(ContentBlock $contentBlock, Photo $photo, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($photo);
        return response()->json(null, 204);
    }
    
    /**
     * ContentBlock photos bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/content_block/content_blocks/photos/bulk_destroy/204.json
     * @responseFile  422 responses/content_block/content_blocks/photos/bulk_destroy/422.json
     *      
     * @param      ContentBlock $contentBlock     
     * @param      BulkDestroyRequest $request
     * @return    JsonResponse
     */
    public function bulkDestroy(ContentBlock $contentBlock, BulkDestroyRequest $request): JsonResponse
    {
        $this->crudService->bulkDestroy($request->ids);
        return response()->json(null, 204);
    }    
    
    /**
     * ContentBlock photos sortable
     *
     * @authenticated
     * 
     * @responseFile  204 responses/content_block/content_blocks/photos/sortable/204.json
     * @responseFile  422 responses/content_block/content_blocks/photos/sortable/422.json
     *      
     * @param      ContentBlock $contentBlock     
     * @param      BulkDestroyRequest $request
     * @return    JsonResponse
     */
    public function sortable(ContentBlock $contentBlock, SortableRequest $request): JsonResponse
    {
        $this->crudService->sortable($request->ids);
        return response()->json(null, 204);
    }
    
}