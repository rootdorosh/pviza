<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Advantage\Models\Category;
use App\Modules\Advantage\Http\Requests\Category\{
    MetaRequest,
    IndexRequest,
    FormRequest,
    ShowRequest,
    DestroyRequest,
    BulkDestroyRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Advantage\Transformers\CategoryTransformer;
use App\Modules\Advantage\Services\Crud\CategoryCrudService;
use App\Modules\Advantage\Services\Fetch\CategoryFetchService;


/**
 * @group  ADVANTAGE
 */
class CategoryController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  CategoryTransformer
     */
    private $transformer;
    
    /**
     * @var  CategoryCrudService
     */
    private $crudService;
    
    /**
     * @var  CategoryFetchService
     */
    private $fetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  CategoryTransformer $transformer
    * @param  CategoryCrudService $crudService
    * @param  CategoryFetchService $fetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        CategoryTransformer $transformer,    
        CategoryCrudService $crudService,    
        CategoryFetchService $fetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;        
    }
    
    /**
     * Categories meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/advantage/categories/meta/200.json
     * 
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('advantage::category'),
			'default' => [
				'rank' => $this->fetchService->getDefaultRank(),
				'is_active' => 1,
			],
		]);
    }

    /**
     * Categories list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/advantage/categories/index/200.json
     * @responseFile  422 responses/advantage/categories/index/422.json
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
     * Categories store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/advantage/categories/store/201.json
     * @responseFile  422 responses/advantage/categories/store/422.json
     * 
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $category = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($category, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * Categories update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/advantage/categories/update/200.json
     * @responseFile  422 responses/advantage/categories/update/422.json
     * @responseFile  404 responses/advantage/categories/update/404.json
     * 
     * @param      Category $category
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Category $category, FormRequest $request): JsonResponse
    {
        $category = $this->crudService->update($category, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($category, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * Categories show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/advantage/categories/show/200.json
     * @responseFile  422 responses/advantage/categories/show/404.json
     * 
     * @param      ShowRequest $request
     * @param      Category $category
     * @return    JsonResponse
     */
    public function show(Category $category, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($category, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }

    /**
     * Categories destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/advantage/categories/destroy/204.json
     * @responseFile  422 responses/advantage/categories/destroy/404.json
     * 
     * @param      DestroyRequest $request
     * @param      Category $category
     * @return    JsonResponse
     */
    public function destroy(Category $category, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($category);
        return response()->json(null, 204);
    }
    
    /**
     * Categories bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/advantage/categories/bulk_destroy/204.json
     * @responseFile  422 responses/advantage/categories/bulk_destroy/422.json
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