<?php

namespace App\Modules\Structure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\Structure\Services\Crud\PageCrudService;
use App\Modules\Structure\Services\StructureService;
use App\Services\Response\FractalManager;
use App\Modules\Structure\Transformers\PageTransformer;
use App\Base\ExtArrHelper;
use App\Modules\Structure\Http\Requests\Page\{
    MetaRequest,
    IndexRequest,
    FormRequest,
    ShowRequest,
    DestroyRequest,
    MoveRequest,
    CopyRequest
};
use App\Modules\Structure\Models\{
    Domain,
    Page
};

/**
 * @group STRUCTURE
 */
class PageController extends Controller
{
    /*
     * var StructureService
     */
    protected $structureService;
    
    /*
     * var PageCrudService
     */
    protected $pageCrudService;
    
    /*
     * var FractalManager
     */
    protected $fractalManager;
    
    /*
     * @var PageTransformer
     */
    private $transformer;
    
    /*
     * @param StructureService   $structureService
     * @param PageCrudService  $pageCrudService
     * @param FractalManager   $fractalManager
     * @param PageTransformer  $transformer
     */
    public function __construct(
        StructureService $structureService, 
        PageCrudService $pageCrudService,
        FractalManager $fractalManager, 
        PageTransformer $transformer
    )
    {
        $this->structureService = $structureService;
        $this->pageCrudService = $pageCrudService;
        $this->fractalManager = $fractalManager;
        $this->transformer = $transformer;
    }
    
    /**
     * Pages meta
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/pages/meta/200.json
     * 
     * @param MetaRequest $request
     * @return  JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
            'labels' => __('structure::page'),
            'templates' => $this->structureService::TEMPLATES,
        ]);
    }

    /**
     * Pages tree
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/pages/index/200.json
     * @responseFile 404 responses/structure/pages/index/404.json
     * 
     * @param   Domain $domain
     * @param   IndexRequest $request
     * @return  JsonResponse
     */
    public function index(Domain $domain, IndexRequest $request): JsonResponse
    {
		$data = $this->structureService->getDomainTree($domain, 'structure_id');
		
        return response()->json(array_shift($data));
    }

    /**
     * Pages store
     *
     * @authenticated
     * 
     * @responseFile 201 responses/structure/pages/store/201.json
     * @responseFile 422 responses/structure/pages/store/422.json
     * @responseFile 404 responses/structure/pages/index/404.json
     * 
     * @param   Domain $domain
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function store(Domain $domain, FormRequest $request): JsonResponse
    {
        $page = $this->pageCrudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($page, $this->transformer->setItemIncludes())
        );
         
        return response()->json(ExtArrHelper::transformModelLang($data), 201);       
    }

    /**
     * Pages update
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/pages/update/200.json
     * @responseFile 422 responses/structure/pages/update/422.json
     * @responseFile 404 responses/structure/pages/update/404.json
     * 
     * @param   Domain $domain
     * @param   Page $page
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function update(Domain $domain, Page $page, FormRequest $request): JsonResponse
    {
        $page = $this->pageCrudService->update($page, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($page, $this->transformer->setItemIncludes())
        );
         
        return response()->json(ExtArrHelper::transformModelLang($data));
    }

    /**
     * Pages show
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/pages/show/200.json
     * @responseFile 404 responses/structure/pages/show/404.json
     * 
     * @param   Domain $domain
     * @param   Page $page
     * @param   ShowRequest $request
     * @return  JsonResponse
     */
    public function show(Domain $domain, Page $page, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($page, $this->transformer->setItemIncludes())
        );
         
        return response()->json(ExtArrHelper::transformModelLang($data));       
    }

    /**
     * Pages destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/structure/pages/destroy/204.json
     * 
     * @param   Domain $domain
     * @param   Page $page
     * @param   DestroyRequest $request
     * @return  JsonResponse
     */
    public function destroy(Domain $domain, Page $page, DestroyRequest $request): JsonResponse
    {
        $this->pageCrudService->destroy($page);
        return response()->json(null, 204);
    }
    
    /**
     * Pages move
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/pages/move/200.json
     * @responseFile 422 responses/structure/pages/move/422.json
     * 
     * @param   Domain $domain
     * @param   Page $page
     * @param   MoveRequest $request
     * @return  JsonResponse
     */
    public function move(Domain $domain, Page $page, MoveRequest $request): JsonResponse
    {
        $page = $this->pageCrudService->move($page, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($page, $this->transformer->setItemIncludes())
        );
         
        return response()->json(ExtArrHelper::transformModelLang($data));
    }

    /**
     * Pages copy
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/pages/copy/200.json
     * 
     * @param   Domain $domain
     * @param   Page $page
     * @param   CopyRequest $request
     * @return  JsonResponse
     */
    public function copy(Domain $domain, Page $page, CopyRequest $request): JsonResponse
    {
        $page = $this->pageCrudService->copy($page, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($page, $this->transformer->setItemIncludes())
        );
         
        return response()->json(ExtArrHelper::transformModelLang($data));
    }
}