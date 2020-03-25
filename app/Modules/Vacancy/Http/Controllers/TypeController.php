<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Vacancy\Models\Type;
use App\Modules\Vacancy\Http\Requests\Type\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	FormRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Vacancy\Transformers\TypeTransformer;
use App\Modules\Vacancy\Services\Crud\TypeCrudService;
use App\Modules\Vacancy\Services\Fetch\TypeFetchService;


/**
 * @group  VACANCY
 */
class TypeController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  TypeTransformer
     */
    private $transformer;
    
    /**
     * @var  TypeCrudService
     */
    private $crudService;
    
    /**
     * @var  TypeFetchService
     */
    private $fetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  TypeTransformer $transformer
    * @param  TypeCrudService $crudService
    * @param  TypeFetchService $fetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        TypeTransformer $transformer,    
        TypeCrudService $crudService,    
        TypeFetchService $fetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;        
    }
    
    /**
     * Types meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/types/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('vacancy::type'),
			'default' => [
				'is_active' => 1,
				'rank' => $this->fetchService->getDefaultRank(),
			],
		]);
    }

    /**
     * Types list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/types/index/200.json
     * @responseFile  422 responses/vacancy/types/index/422.json
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
     * Types store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/vacancy/types/store/201.json
     * @responseFile  422 responses/vacancy/types/store/422.json
     *      
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $type = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($type, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Types update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/types/update/200.json
     * @responseFile  422 responses/vacancy/types/update/422.json
     * @responseFile  404 responses/vacancy/types/update/404.json
     *      
     * @param      Type $type
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Type $type, FormRequest $request): JsonResponse
    {
        $type = $this->crudService->update($type, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($type, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Types show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/types/show/200.json
     * @responseFile  422 responses/vacancy/types/show/404.json
     *      
     * @param      Type $type
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Type $type, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($type, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }
    /**
     * Types destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/vacancy/types/destroy/204.json
     * @responseFile  422 responses/vacancy/types/destroy/404.json
     *      
     * @param      Type $type
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Type $type, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($type);
        return response()->json(null, 204);
    }
    
    /**
     * Types bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/vacancy/types/bulk_destroy/204.json
     * @responseFile  422 responses/vacancy/types/bulk_destroy/422.json
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