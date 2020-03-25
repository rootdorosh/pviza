<?php

namespace App\Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\User\Services\Crud\RoleCrudService;
use App\Modules\User\Services\Fetch\PermissionFetchService;
use App\Services\Response\FractalManager;
use App\Modules\User\Models\Role;
use App\Modules\User\Transformers\RoleTransformer;
use App\Modules\User\Http\Requests\Role\{
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
class RoleController extends Controller
{
    /*
     * var RoleCrudService
     */
    protected $crudService;
    
    /*
     * var PermissionFetchService
     */
    protected $permissionFetchService;
    
    /*
     * var FractalManager
     */
    protected $fractalManager;

    /*
     * @var RoleTransformer
     */
    private $transformer;
    
    /*
     * @param FractalManager            $fractalManager
     * @param RoleCrudService           $crudService
     * @param PermissionFetchService    $crudService
     * @param RoleTransformer           $transformer
     */
    public function __construct(
        FractalManager $fractalManager, 
        RoleCrudService $crudService,
        PermissionFetchService $permissionFetchService,
        RoleTransformer $transformer
    )
    {
        $this->fractalManager = $fractalManager;
        $this->crudService = $crudService;
        $this->permissionFetchService = $permissionFetchService;
        $this->transformer = $transformer;
    }
    
    /**
     * Roles meta
     *
     * @authenticated
     * 
     * @responseFile 200 responses/user/roles/meta/200.json
     * 
     * @param MetaRequest $request
     * @return  JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
            'labels' => __('user::role'),
            'permissions' => $this->permissionFetchService->getList(),
        ]);
    }

    /**
     * Roles list
     *
     * @authenticated
     * 
     * @responseFile 200 responses/user/roles/index/200.json
     * @responseFile 422 responses/user/roles/index/422.json
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
     * Roles store
     *
     * @authenticated
     * 
     * @responseFile 201 responses/user/roles/store/201.json
     * @responseFile 422 responses/user/roles/store/422.json
     * 
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $role = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($role, $this->transformer->setItemIncludes())
        );
         
        return response()->json($data, 201);       
    }

    /**
     * Roles update
     *
     * @authenticated
     * 
     * @responseFile 200 responses/user/roles/update/200.json
     * @responseFile 422 responses/user/roles/update/422.json
     * @responseFile 404 responses/user/roles/update/404.json
     * 
     * @param   Role $role
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function update(Role $role, FormRequest $request): JsonResponse
    {
        $role = $this->crudService->update($role, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($role, $this->transformer->setItemIncludes())
        );
         
        return response()->json($data);
    }

    /**
     * Roles show
     *
     * @authenticated
     * 
     * @responseFile 200 responses/user/roles/show/200.json
     * @responseFile 422 responses/user/roles/show/404.json
     * 
     * @param   ShowRequest $request
     * @param   Role $role
     * @return  JsonResponse
     */
    public function show(Role $role, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($role, $this->transformer->setItemIncludes())
        );
         
        return response()->json($data);       
    }

    /**
     * Roles destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/user/roles/destroy/204.json
     * @responseFile 422 responses/user/roles/destroy/404.json
     * 
     * @param   DestroyRequest $request
     * @param   Role $role
     * @return  JsonResponse
     */
    public function destroy(Role $role, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($role);
        return response()->json(null, 204);
    }

    /**
     * Roles bulk destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/user/roles/bulk_destroy/204.json
     * @responseFile 422 responses/user/roles/bulk_destroy/422.json
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