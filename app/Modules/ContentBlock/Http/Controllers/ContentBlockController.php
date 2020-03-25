<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\ContentBlock\Http\Requests\ContentBlock\{
    MetaRequest,
	IndexRequest,
	FormRequest,
	ShowRequest,
	DestroyRequest,
	BulkDestroyRequest
};
use App\Services\Response\FractalManager;
use App\Modules\ContentBlock\Transformers\ContentBlockTransformer;
use App\Modules\ContentBlock\Services\Crud\ContentBlockCrudService;


/**
 * @group  CONTENT_BLOCK
 */
class ContentBlockController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  ContentBlockTransformer
     */
    private $transformer;
    
    /**
     * @var  ContentBlockCrudService
     */
    private $crudService;

    /*
    * @param  FractalManager $fractalManager
    * @param  ContentBlockTransformer $transformer
    * @param  ContentBlockCrudService $crudService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        ContentBlockTransformer $transformer,    
        ContentBlockCrudService $crudService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;        
    }
    
    /**
     * ContentBlocks meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/content_block/content_blocks/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('contentBlock::content_block'),
			'default' => [
				'is_active' => 1,
				'is_hide_editor' => 0,
			],
			'adaptive_images' => ExtArrHelper::adaptiveImage('ContentBlock', 'ContentBlock'),
		]);
    }

    /**
     * ContentBlocks list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/content_block/content_blocks/index/200.json
     * @responseFile  422 responses/content_block/content_blocks/index/422.json
     *      
     * @param      IndexRequest $request
     * @return    JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
    
        return response()->json($this->fractalManager->collectionToFractalPaginate(
            $request,
            $request->paginate(),
            $this->transformer
        ));
    }

    /**
     * ContentBlocks store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/content_block/content_blocks/store/201.json
     * @responseFile  422 responses/content_block/content_blocks/store/422.json
     *      
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $contentBlock = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($contentBlock, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * ContentBlocks update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/content_block/content_blocks/update/200.json
     * @responseFile  422 responses/content_block/content_blocks/update/422.json
     * @responseFile  404 responses/content_block/content_blocks/update/404.json
     *      
     * @param      ContentBlock $contentBlock
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(ContentBlock $contentBlock, FormRequest $request): JsonResponse
    {
        $contentBlock = $this->crudService->update($contentBlock, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($contentBlock, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * ContentBlocks show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/content_block/content_blocks/show/200.json
     * @responseFile  422 responses/content_block/content_blocks/show/404.json
     *      
     * @param      ContentBlock $contentBlock
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(ContentBlock $contentBlock, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($contentBlock, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }

    /**
     * ContentBlocks destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/content_block/content_blocks/destroy/204.json
     * @responseFile  422 responses/content_block/content_blocks/destroy/404.json
     *      
     * @param      ContentBlock $contentBlock
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(ContentBlock $contentBlock, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($contentBlock);
        return response()->json(null, 204);
    }
    
    /**
     * ContentBlocks bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/content_block/content_blocks/bulk_destroy/204.json
     * @responseFile  422 responses/content_block/content_blocks/bulk_destroy/422.json
     *      
     * @param      BulkDestroyRequest $request
     * @return    JsonResponse
     */
    public function bulkDestroy(BulkDestroyRequest $request): JsonResponse
    {
        $this->crudService->bulkDestroy($request->ids);
        return response()->json(null, 204);
    }    
    
}