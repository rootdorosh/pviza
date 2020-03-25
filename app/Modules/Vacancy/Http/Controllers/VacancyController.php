<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Vacancy\Models\Vacancy;
use App\Modules\Vacancy\Http\Requests\Vacancy\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	FormRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Vacancy\Transformers\VacancyTransformer;
use App\Modules\Vacancy\Services\Crud\VacancyCrudService;
use App\Modules\Vacancy\Services\Fetch\VacancyFetchService;
use App\Modules\Vacancy\Services\Fetch\CategoryFetchService;
use App\Modules\Vacancy\Services\Fetch\LocationFetchService;
use App\Modules\Vacancy\Services\Fetch\TypeFetchService;


/**
 * @group  VACANCY
 */
class VacancyController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  VacancyTransformer
     */
    private $transformer;
    
    /**
     * @var  VacancyCrudService
     */
    private $crudService;
    
    /**
     * @var  VacancyFetchService
     */
    private $fetchService;
    
    /**
     * @var  CategoryFetchService
     */
    private $categoryFetchService;
    
    /**
     * @var  LocationFetchService
     */
    private $locationFetchService;
    
    /**
     * @var  TypeFetchService
     */
    private $typeFetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  VacancyTransformer $transformer
    * @param  VacancyCrudService $crudService
    * @param  VacancyFetchService $fetchService
    * @param  CategoryFetchService $categoryFetchService
    * @param  LocationFetchService $locationFetchService
    * @param  TypeFetchService $typeFetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        VacancyTransformer $transformer,    
        VacancyCrudService $crudService,    
        VacancyFetchService $fetchService,    
        CategoryFetchService $categoryFetchService,    
        LocationFetchService $locationFetchService,    
        TypeFetchService $typeFetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;    
        $this->categoryFetchService = $categoryFetchService;    
        $this->locationFetchService = $locationFetchService;    
        $this->typeFetchService = $typeFetchService;        
    }
    
    /**
     * Vacancies meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/vacancies/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('vacancy::vacancy'),
			'default' => [
				'is_active' => 1,
				'is_popular' => 0,
				'rank' => $this->fetchService->getDefaultRank(),
			],
			'options' => [
				'categories' => ExtArrHelper::valueTextFromList($this->categoryFetchService->getList()),
				'types' => ExtArrHelper::valueTextFromList($this->typeFetchService->getList()),
				'locations' => ExtArrHelper::valueTextFromList($this->locationFetchService->getList()),
			],
		]);
    }

    /**
     * Vacancies list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/vacancies/index/200.json
     * @responseFile  422 responses/vacancy/vacancies/index/422.json
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
     * Vacancies store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/vacancy/vacancies/store/201.json
     * @responseFile  422 responses/vacancy/vacancies/store/422.json
     *      
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $vacancy = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($vacancy, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Vacancies update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/vacancies/update/200.json
     * @responseFile  422 responses/vacancy/vacancies/update/422.json
     * @responseFile  404 responses/vacancy/vacancies/update/404.json
     *      
     * @param      Vacancy $vacancy
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Vacancy $vacancy, FormRequest $request): JsonResponse
    {
        $vacancy = $this->crudService->update($vacancy, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($vacancy, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Vacancies show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/vacancy/vacancies/show/200.json
     * @responseFile  422 responses/vacancy/vacancies/show/404.json
     *      
     * @param      Vacancy $vacancy
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Vacancy $vacancy, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($vacancy, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }
    /**
     * Vacancies destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/vacancy/vacancies/destroy/204.json
     * @responseFile  422 responses/vacancy/vacancies/destroy/404.json
     *      
     * @param      Vacancy $vacancy
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Vacancy $vacancy, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($vacancy);
        return response()->json(null, 204);
    }
    
    /**
     * Vacancies bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/vacancy/vacancies/bulk_destroy/204.json
     * @responseFile  422 responses/vacancy/vacancies/bulk_destroy/422.json
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