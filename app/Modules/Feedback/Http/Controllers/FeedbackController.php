<?php 

declare( strict_types = 1 );

namespace App\Modules\Feedback\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Feedback\Models\Feedback;
use App\Modules\Feedback\Http\Requests\Feedback\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Feedback\Transformers\FeedbackTransformer;
use App\Modules\Feedback\Services\Crud\FeedbackCrudService;


/**
 * @group  FEEDBACK
 */
class FeedbackController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  FeedbackTransformer
     */
    private $transformer;
    
    /**
     * @var  FeedbackCrudService
     */
    private $crudService;

    /*
    * @param  FractalManager $fractalManager
    * @param  FeedbackTransformer $transformer
    * @param  FeedbackCrudService $crudService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        FeedbackTransformer $transformer,    
        FeedbackCrudService $crudService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;        
    }
    
    /**
     * Feedbacks meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/feedback/feedbacks/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('feedback::feedback'),
		]);
    }

    /**
     * Feedbacks list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/feedback/feedbacks/index/200.json
     * @responseFile  422 responses/feedback/feedbacks/index/422.json
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
     * Feedbacks show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/feedback/feedbacks/show/200.json
     * @responseFile  422 responses/feedback/feedbacks/show/404.json
     *      
     * @param      Feedback $feedback
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Feedback $feedback, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($feedback, $this->transformer->setItemIncludes())
        );
        return response()->json($data, 200);            
    }
    /**
     * Feedbacks destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/feedback/feedbacks/destroy/204.json
     * @responseFile  422 responses/feedback/feedbacks/destroy/404.json
     *      
     * @param      Feedback $feedback
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Feedback $feedback, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($feedback);
        return response()->json(null, 204);
    }
    
    /**
     * Feedbacks bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/feedback/feedbacks/bulk_destroy/204.json
     * @responseFile  422 responses/feedback/feedbacks/bulk_destroy/422.json
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