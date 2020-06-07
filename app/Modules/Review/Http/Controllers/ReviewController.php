<?php 

declare( strict_types = 1 );

namespace App\Modules\Review\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Review\Models\Review;
use App\Modules\Review\Http\Requests\Review\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	FormRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Review\Transformers\ReviewTransformer;
use App\Modules\Review\Services\Crud\ReviewCrudService;
use App\Modules\Review\Services\Fetch\ReviewFetchService;


/**
 * @group  REVIEW
 */
class ReviewController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  ReviewTransformer
     */
    private $transformer;
    
    /**
     * @var  ReviewCrudService
     */
    private $crudService;
    
    /**
     * @var  ReviewFetchService
     */
    private $fetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  ReviewTransformer $transformer
    * @param  ReviewCrudService $crudService
    * @param  ReviewFetchService $fetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        ReviewTransformer $transformer,    
        ReviewCrudService $crudService,    
        ReviewFetchService $fetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;        
    }
    
    /**
     * Reviews meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/review/reviews/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('review::review'),
			'default' => [
				'is_active' => 1,
				'is_home' => 0,
			],
		]);
    }

    /**
     * Reviews list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/review/reviews/index/200.json
     * @responseFile  422 responses/review/reviews/index/422.json
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
     * Reviews store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/review/reviews/store/201.json
     * @responseFile  422 responses/review/reviews/store/422.json
     *      
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $review = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($review, $this->transformer->setItemIncludes())
        );
        return response()->json($data, 201);            
    }
    /**
     * Reviews update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/review/reviews/update/200.json
     * @responseFile  422 responses/review/reviews/update/422.json
     * @responseFile  404 responses/review/reviews/update/404.json
     *      
     * @param      Review $review
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Review $review, FormRequest $request): JsonResponse
    {
        $review = $this->crudService->update($review, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($review, $this->transformer->setItemIncludes())
        );
        return response()->json($data, 201);            
    }
    /**
     * Reviews show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/review/reviews/show/200.json
     * @responseFile  422 responses/review/reviews/show/404.json
     *      
     * @param      Review $review
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Review $review, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($review, $this->transformer->setItemIncludes())
        );
        return response()->json($data, 200);            
    }
    /**
     * Reviews destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/review/reviews/destroy/204.json
     * @responseFile  422 responses/review/reviews/destroy/404.json
     *      
     * @param      Review $review
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Review $review, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($review);
        return response()->json(null, 204);
    }
    
    /**
     * Reviews bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/review/reviews/bulk_destroy/204.json
     * @responseFile  422 responses/review/reviews/bulk_destroy/422.json
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