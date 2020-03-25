<?php

namespace App\Modules\Structure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\Structure\Services\Crud\BlockCrudService;
use App\Modules\Structure\Services\Fetch\BlockFetchService;
use App\Modules\Structure\Services\StructureService;
use App\Modules\Structure\Http\Requests\Block\{
    MetaRequest,
    IndexRequest,
    ShowRequest,
    InsertRequest,
    DestroyRequest
};
use App\Modules\Structure\Models\{
    Domain,
    Page,
    Block
};
use App\Base\ScmsHelper;

/**
 * @group STRUCTURE
 */
class BlockController extends Controller
{
    /*
     * var StructureService
     */
    protected $structureService;
    
    /*
     * var BlockCrudService
     */
    protected $blockCrudService;
        
    
    /*
     * @param StructureService   $structureService
     * @param BlockCrudService  $blockCrudService
     * @param BlockFetchService  $blockFetchService
     */
    public function __construct(
        StructureService $structureService, 
        BlockCrudService $blockCrudService,
        BlockFetchService $blockFetchService
    )
    {
        $this->structureService = $structureService;
        $this->blockCrudService = $blockCrudService;
        $this->blockFetchService = $blockFetchService;
    }
    
    /**
     * Blocks meta
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/blocks/meta/200.json
     * 
     * @param MetaRequest $request
     * @return  JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
            'labels' => __('structure::block'),
            'widgets' => ScmsHelper::getWidgets(),
        ]);
    }
    
    /**
     * Blocks index
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/blocks/index/200.json
     * 
     * @param Domain $domain
     * @param Page $page
     * @param IndexRequest $request
     * @return  JsonResponse
     */
    public function index(Domain $domain, Page $page, IndexRequest $request): JsonResponse
    {
        return response()->json($this->structureService->getPageBlocksData($page));
    }
    
    /**
     * Block show
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/blocks/show/200.json
     * @responseFile 204 responses/structure/blocks/show/204.json
     * 
     * @param   Domain $domain
     * @param   Page $page
     * @param   string $alias
     * @param   DestroyRequest $request
     * @return  JsonResponse
     */
    public function show(Domain $domain, Page $page, string $alias, ShowRequest $request): JsonResponse
    {
        $data = $this->blockFetchService->itemByPageAndAlias($page->id, $alias);
        if (!empty($data)) {
            $data['meta'] = ScmsHelper::getWidgetInfo($data['widget_id']);
        }
        
        return response()->json($data, $data ? 200 : 204);
    }    

    /**
     * Blocks insert
     *
     * @authenticated
     * 
     * @responseFile 204 responses/structure/blocks/insert/204.json
     * @responseFile 422 responses/structure/blocks/insert/422.json
     * 
     * @param   Domain $domain
     * @param   Page $page
     * @param   InsertRequest $request
     * @return  JsonResponse
     */
    public function insert(Domain $domain, Page $page, InsertRequest $request): JsonResponse
    {
        $block = $this->blockCrudService->insert($page, $request->validated());                
        return response()->json(null, 204);       
    }

    /**
     * Blocks destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/structure/blocks/destroy/204.json
     * 
     * @param   Domain $domain
     * @param   Page $page
     * @param   string $alias
     * @param   DestroyRequest $request
     * @return  JsonResponse
     */
    public function destroy(Domain $domain, Page $page, string $alias, DestroyRequest $request): JsonResponse
    {
        $this->blockCrudService->destroy($page, $alias);
        return response()->json(null, 204);
    }    
}