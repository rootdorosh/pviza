<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Advantage\Models\Advantage;
use App\Modules\Advantage\Http\Requests\Advantage\{
    MetaRequest,
    IndexRequest,
    FormRequest,
    ShowRequest,
    DestroyRequest,
    BulkDestroyRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Advantage\Transformers\AdvantageTransformer;
use App\Modules\Advantage\Services\Crud\AdvantageCrudService;
use App\Modules\Advantage\Services\Fetch\AdvantageFetchService;
use App\Modules\Advantage\Services\Fetch\CategoryFetchService;


/**
 * @group  ADVANTAGE
 */
class AdvantageController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  AdvantageTransformer
     */
    private $transformer;
    
    /**
     * @var  AdvantageCrudService
     */
    private $crudService;
    
    /**
     * @var  AdvantageFetchService
     */
    private $fetchService;
    
    /**
     * @var  CategoryFetchService
     */
    private $categoryFetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  AdvantageTransformer $transformer
    * @param  AdvantageCrudService $crudService
    * @param  AdvantageFetchService $fetchService
    * @param  CategoryFetchService $categoryFetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        AdvantageTransformer $transformer,    
        AdvantageCrudService $crudService,    
        AdvantageFetchService $fetchService,    
        CategoryFetchService $categoryFetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;    
        $this->categoryFetchService = $categoryFetchService;        
    }
    
    /**
     * Advantages meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/advantage/advantages/meta/200.json
     * 
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('advantage::advantage'),
			'options' => [
				'categories' => ExtArrHelper::valueTextFromList($this->categoryFetchService->getList()),
			],
			'default' => [
				'rank' => $this->fetchService->getDefaultRank(),
				'is_active' => 1,
			],
		]);
    }

    /**
     * Advantages list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/advantage/advantages/index/200.json
     * @responseFile  422 responses/advantage/advantages/index/422.json
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
     * Advantages store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/advantage/advantages/store/201.json
     * @responseFile  422 responses/advantage/advantages/store/422.json
     * 
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $advantage = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($advantage, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * Advantages update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/advantage/advantages/update/200.json
     * @responseFile  422 responses/advantage/advantages/update/422.json
     * @responseFile  404 responses/advantage/advantages/update/404.json
     * 
     * @param      Advantage $advantage
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Advantage $advantage, FormRequest $request): JsonResponse
    {
        $advantage = $this->crudService->update($advantage, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($advantage, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * Advantages show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/advantage/advantages/show/200.json
     * @responseFile  422 responses/advantage/advantages/show/404.json
     * 
     * @param      ShowRequest $request
     * @param      Advantage $advantage
     * @return    JsonResponse
     */
    public function show(Advantage $advantage, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($advantage, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }

    /**
     * Advantages destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/advantage/advantages/destroy/204.json
     * @responseFile  422 responses/advantage/advantages/destroy/404.json
     * 
     * @param      DestroyRequest $request
     * @param      Advantage $advantage
     * @return    JsonResponse
     */
    public function destroy(Advantage $advantage, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($advantage);
        return response()->json(null, 204);
    }
    
    /**
     * Advantages bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/advantage/advantages/bulk_destroy/204.json
     * @responseFile  422 responses/advantage/advantages/bulk_destroy/422.json
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