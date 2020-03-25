<?php

namespace App\Modules\Structure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\Structure\Services\Crud\DomainCrudService;
use App\Services\Response\FractalManager;
use App\Modules\Structure\Models\Domain;
use App\Modules\Structure\Transformers\DomainTransformer;
use App\Base\ExtArrHelper;
use App\Modules\Structure\Http\Requests\Domain\{
    MetaRequest,
    IndexRequest,
    FormRequest,
    ShowRequest,
    DestroyRequest,
    BulkDestroyRequest
};

/**
 * @group STRUCTURE
 */
class DomainController extends Controller
{
    /*
     * var FractalManager
     */
    protected $fractalManager;
    
    /*
     * @var DomainTransformer
     */
    private $domainTransformer;
    
    /*
     * @param FractalManager    $fractalManager
     * @param DomainCrudService  $crudService
     * @param DomainTransformer  $domainTransformer
     */
    public function __construct(
        FractalManager $fractalManager, 
        DomainCrudService $crudService,
        DomainTransformer $domainTransformer
    )
    {
        $this->crudService = $crudService;
        $this->fractalManager = $fractalManager;
        $this->domainTransformer = $domainTransformer;
    }
    
    /**
     * Domains meta
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/domains/meta/200.json
     * 
     * @param MetaRequest $request
     * @return  JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
            'labels' => __('structure::domain'),
            'options' => [
                'languages' => config('translatable.locales'),
            ],
            
        ]);
    }

    /**
     * Domains list
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/domains/index/200.json
     * @responseFile 422 responses/structure/domains/index/422.json
     * 
     * @param   IndexRequest $request
     * @return  JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        return response()->json($this->fractalManager->collectionToFractalPaginate(
            $request,
            $request->paginate(),
            $this->domainTransformer
        ));
    }

    /**
     * Domains store
     *
     * @authenticated
     * 
     * @responseFile 201 responses/structure/domains/store/201.json
     * @responseFile 422 responses/structure/domains/store/422.json
     * 
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $domain = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($domain, $this->domainTransformer->setItemIncludes())
        );
         
        return response()->json(ExtArrHelper::transformModelLang($data), 201);       
    }

    /**
     * Domains update
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/domains/update/200.json
     * @responseFile 422 responses/structure/domains/update/422.json
     * @responseFile 404 responses/structure/domains/update/404.json
     * 
     * @param   Domain $domain
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function update(Domain $domain, FormRequest $request): JsonResponse
    {
        $domain = $this->crudService->update($domain, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($domain, $this->domainTransformer->setItemIncludes())
        );
         
        return response()->json(ExtArrHelper::transformModelLang($data));
    }

    /**
     * Domains show
     *
     * @authenticated
     * 
     * @responseFile 200 responses/structure/domains/show/200.json
     * @responseFile 422 responses/structure/domains/show/404.json
     * 
     * @param   Domain $domain
     * @param   ShowRequest $request
     * @return  JsonResponse
     */
    public function show(Domain $domain, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($domain, $this->domainTransformer->setItemIncludes())
        );
         
        return response()->json(ExtArrHelper::transformModelLang($data));       
    }

    /**
     * Domains destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/structure/domains/destroy/204.json
     * 
     * @param   Domain $domain
     * @param   DestroyRequest $request
     * @return  JsonResponse
     */
    public function destroy(Domain $domain, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($domain);
        return response()->json(null, 204);
    }
    
    /**
     * Domains bulk destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/structure/domains/bulk_destroy/204.json
     * @responseFile 422 responses/structure/domains/bulk_destroy/422.json
     * 
     * @param   BulkDestroyRequest $request
     * @return  JsonResponse
     */
    public function bulkDestroy(BulkDestroyRequest $request): JsonResponse
    {
        $this->crudService->bulkDestroy($request->ids);
        return response()->json(null, 204);
    }
    
}