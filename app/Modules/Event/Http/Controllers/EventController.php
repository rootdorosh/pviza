<?php 

declare( strict_types = 1 );

namespace App\Modules\Event\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Http\Requests\Event\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	FormRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Event\Transformers\EventTransformer;
use App\Modules\Event\Services\Crud\EventCrudService;



/**
 * @group  EVENT
 */
class EventController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  EventTransformer
     */
    private $transformer;
    
    /**
     * @var  EventCrudService
     */
    private $crudService;

    /*
    * @param  FractalManager $fractalManager
    * @param  EventTransformer $transformer
    * @param  EventCrudService $crudService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        EventTransformer $transformer,    
        EventCrudService $crudService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;        
    }
    
    /**
     * Events meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/event/events/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('event::event'),
			'default' => [
				'is_active' => 1,
				'content_type' => Event::CONTENT_TYPE_TEXT_HTML,
			],
			'options' => [
				'content_types' => Event::CONTENT_TYPES,
			],            
		]);
    }

    /**
     * Events list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/event/events/index/200.json
     * @responseFile  422 responses/event/events/index/422.json
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
     * Events update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/event/events/update/200.json
     * @responseFile  422 responses/event/events/update/422.json
     * @responseFile  404 responses/event/events/update/404.json
     *      
     * @param      Event $event
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Event $event, FormRequest $request): JsonResponse
    {
        $event = $this->crudService->update($event, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($event, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * Events show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/event/events/show/200.json
     * @responseFile  422 responses/event/events/show/404.json
     *      
     * @param      Event $event
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Event $event, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($event, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }
    /**
     * Events destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/event/events/destroy/204.json
     * @responseFile  422 responses/event/events/destroy/404.json
     *      
     * @param      Event $event
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Event $event, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($event);
        return response()->json(null, 204);
    }
    
    /**
     * Events bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/event/events/bulk_destroy/204.json
     * @responseFile  422 responses/event/events/bulk_destroy/422.json
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