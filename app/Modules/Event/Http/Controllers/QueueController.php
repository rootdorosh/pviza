<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\Event\Models\Queue;
use App\Modules\Event\Http\Requests\Queue\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Event\Transformers\QueueTransformer;
use App\Modules\Event\Services\Crud\QueueCrudService;
use App\Modules\Event\Services\Fetch\QueueFetchService;


/**
 * @group  EVENT
 */
class QueueController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  QueueTransformer
     */
    private $transformer;
    
    /**
     * @var  QueueCrudService
     */
    private $crudService;
    
    /**
     * @var  QueueFetchService
     */
    private $fetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  QueueTransformer $transformer
    * @param  QueueCrudService $crudService
    * @param  QueueFetchService $fetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        QueueTransformer $transformer,    
        QueueCrudService $crudService,    
        QueueFetchService $fetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;        
    }
    
    /**
     * Queues meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/event/queues/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('event::queue'),
		]);
    }

    /**
     * Queues list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/event/queues/index/200.json
     * @responseFile  422 responses/event/queues/index/422.json
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
     * Queues destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/event/queues/destroy/204.json
     * @responseFile  422 responses/event/queues/destroy/404.json
     *      
     * @param      Queue $queue
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Queue $queue, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($queue);
        return response()->json(null, 204);
    }
    
    /**
     * Queues bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/event/queues/bulk_destroy/204.json
     * @responseFile  422 responses/event/queues/bulk_destroy/422.json
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