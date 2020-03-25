<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Vacancy\Models\Location;
use App\Modules\Vacancy\Http\Requests\Location\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	FormRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Vacancy\Transformers\LocationTransformer;
use App\Modules\Vacancy\Services\Crud\LocationCrudService;
use App\Modules\Vacancy\Services\Fetch\LocationFetchService;


/**
 * @group  VACANCY
 */
class LocationController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  LocationTransformer
     */
    private $transformer;
    
    /**
     * @var  LocationCrudService
     */
    private $crudService;
    
    /**
     * @var  LocationFetchService
     */
    private $fetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  LocationTransformer $transformer
    * @param  LocationCrudService $crudService
    * @param  LocationFetchService $fetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        LocationTransformer $transformer,    
        LocationCrudService $crudService,    
        LocationFetchService $fetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;        
    }
    
    /**
     * Locations meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/locations/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('vacancy::location'),
			'default' => [
				'is_active' => 1,
				'rank' => $this->fetchService->getDefaultRank(),
			],
		]);
    }

    /**
     * Locations list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/locations/index/200.json
     * @responseFile  422 responses/vacancy/locations/index/422.json
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
     * Locations store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/vacancy/locations/store/201.json
     * @responseFile  422 responses/vacancy/locations/store/422.json
     *      
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $location = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($location, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Locations update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/locations/update/200.json
     * @responseFile  422 responses/vacancy/locations/update/422.json
     * @responseFile  404 responses/vacancy/locations/update/404.json
     *      
     * @param      Location $location
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Location $location, FormRequest $request): JsonResponse
    {
        $location = $this->crudService->update($location, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($location, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Locations show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/locations/show/200.json
     * @responseFile  422 responses/vacancy/locations/show/404.json
     *      
     * @param      Location $location
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Location $location, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($location, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }
    /**
     * Locations destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/vacancy/locations/destroy/204.json
     * @responseFile  422 responses/vacancy/locations/destroy/404.json
     *      
     * @param      Location $location
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Location $location, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($location);
        return response()->json(null, 204);
    }
    
    /**
     * Locations bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/vacancy/locations/bulk_destroy/204.json
     * @responseFile  422 responses/vacancy/locations/bulk_destroy/422.json
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