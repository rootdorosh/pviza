<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\User\Services\Crud\UserCrudService;
use App\Modules\User\Services\Fetch\RoleFetchService;
use App\Modules\Event\Services\Fetch\EventFetchService;
use App\Services\Response\FractalManager;
use App\Modules\User\Models\User;
use App\Modules\User\Transformers\UserTransformer;
use App\Modules\User\Http\Requests\User\{
    MetaRequest,
    IndexRequest,
    FormRequest,
    ShowRequest,
    DestroyRequest,
    BulkDestroyRequest
};

/**
 * @group USER
 */
class UserController extends Controller
{
    /*
     * var UserCrudService
     */
    protected $crudService;
    
    /*
     * var RoleFetchService
     */
    protected $roleFetchService;
    
    /*
     * var EventFetchService
     */
    protected $eventFetchService;
    
    /*
     * var FractalManager
     */
    protected $fractalManager;

    /*
     * @var UserTransformer
     */
    private $transformer;
    
    /*
     * @param FractalManager      $fractalManager
     * @param UserCrudService     $crudService
     * @param RoleFetchService    $roleFetchService
     * @param EventFetchService   $eventFetchService
     * @param UserTransformer     $transformer
     */
    public function __construct(
        FractalManager $fractalManager, 
        UserCrudService $crudService,
        RoleFetchService $roleFetchService,
        EventFetchService $eventFetchService,
        UserTransformer $transformer
    )
    {
        $this->fractalManager = $fractalManager;
        $this->crudService = $crudService;
        $this->roleFetchService = $roleFetchService;
        $this->eventFetchService = $eventFetchService;
        $this->transformer = $transformer;
    }
    
    /**
     * Users meta
     *
     * @authenticated
     * 
     * @responseFile 200 responses/user/users/meta/200.json
     * 
     * @param MetaRequest $request
     * @return  JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
            'labels' => __('user::user'),
            'roles' => $this->roleFetchService->getList(),
            'events' => $this->eventFetchService->getList(),
        ]);
    }

    /**
     * Users list
     *
     * @authenticated
     * 
     * @responseFile 200 responses/user/users/index/200.json
     * @responseFile 422 responses/user/users/index/422.json
     * 
     * @param   IndexRequest $request
     * @return  JsonResponse
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
     * Users store
     *
     * @authenticated
     * 
     * @responseFile 201 responses/user/users/store/201.json
     * @responseFile 422 responses/user/users/store/422.json
     * 
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $user = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($user, $this->transformer->setItemIncludes())
        );
         
        return response()->json($data, 201);       
    }

    /**
     * Users update
     *
     * @authenticated
     * 
     * @responseFile 200 responses/user/users/update/200.json
     * @responseFile 422 responses/user/users/update/422.json
     * @responseFile 404 responses/user/users/update/404.json
     * 
     * @param   User $user
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function update(User $user, FormRequest $request): JsonResponse
    {
        $user = $this->crudService->update($user, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($user, $this->transformer->setItemIncludes())
        );
         
        return response()->json($data);
    }

    /**
     * Users show
     *
     * @authenticated
     * 
     * @responseFile 200 responses/user/users/show/200.json
     * @responseFile 422 responses/user/users/show/404.json
     * 
     * @param   ShowRequest $request
     * @param   User $user
     * @return  JsonResponse
     */
    public function show(User $user, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($user, $this->transformer->setItemIncludes())
        );
         
        return response()->json($data);       
    }

    /**
     * Users destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/user/users/destroy/204.json
     * @responseFile 422 responses/user/users/destroy/404.json
     * 
     * @param   DestroyRequest $request
     * @param   User $user
     * @return  JsonResponse
     */
    public function destroy(User $user, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($user);
        return response()->json(null, 204);
    }
    
    /**
     * Users bulk destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/user/users/bulk_destroy/204.json
     * @responseFile 422 responses/user/users/bulk_destroy/422.json
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