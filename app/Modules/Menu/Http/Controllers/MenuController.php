<?php 

declare( strict_types = 1 );

namespace App\Modules\Menu\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\Menu\Services\Crud\MenuCrudService;
use App\Services\Response\FractalManager;
use App\Modules\Menu\Models\Menu;
use App\Modules\Menu\Transformers\MenuTransformer;
use App\Modules\Menu\Http\Requests\Menu\{
    MetaRequest,
    IndexRequest,
    FormRequest,
    ShowRequest,
    DestroyRequest,
    BulkDestroyRequest
};

/**
 * @group  MENU
 */
class MenuController extends Controller
{
    /*
     * var MenuCrudService
     */
    protected $crudService;
    
    /*
     * var FractalManager
     */
    protected $fractalManager;

    /*
     * @var  MenuTransformer
     */
    private $transformer;
    
    /*
     * @param  FractalManager            $fractalManager
     * @param  MenuCrudService           $crudService
     * @param  MenuTransformer           $transformer
     */
    public function __construct(
        FractalManager $fractalManager, 
        MenuCrudService $crudService,
        MenuTransformer $transformer
    )
    {
        $this->fractalManager = $fractalManager;
        $this->crudService = $crudService;
        $this->transformer = $transformer;
    }
    
    /**
     * Menus meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/menu/menus/meta/200.json
     * 
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
            'labels' => [
                'menu' => __('menu::menu'),
                'item' => __('menu::item') + [
                    'changefreqs' => Menu::SM_CHANGEFREQS,
                    'priorities' => Menu::SM_PRIORITIES,
                ],
            ],
        ]);
    }

    /**
     * Menus list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/menu/menus/index/200.json
     * @responseFile  422 responses/menu/menus/index/422.json
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
     * Menus store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/menu/menus/store/201.json
     * @responseFile  422 responses/menu/menus/store/422.json
     * 
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $menu = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($menu, $this->transformer->setItemIncludes())
        );
        return response()->json($data, 201);            
    }

    /**
     * Menus update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/menu/menus/update/200.json
     * @responseFile  422 responses/menu/menus/update/422.json
     * @responseFile  404 responses/menu/menus/update/404.json
     * 
     * @param      Menu $menu
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Menu $menu, FormRequest $request): JsonResponse
    {
        $menu = $this->crudService->update($menu, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($menu, $this->transformer->setItemIncludes())
        );
        return response()->json($data, 201);            
    }

    /**
     * Menus show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/menu/menus/show/200.json
     * @responseFile  422 responses/menu/menus/show/404.json
     * 
     * @param      ShowRequest $request
     * @param      Menu $menu
     * @return    JsonResponse
     */
    public function show(Menu $menu, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($menu, $this->transformer->setItemIncludes())
        );
        return response()->json($data, 200);            
    }

    /**
     * Menus destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/menu/menus/destroy/204.json
     * @responseFile  422 responses/menu/menus/destroy/404.json
     * 
     * @param      DestroyRequest $request
     * @param      Menu $menu
     * @return    JsonResponse
     */
    public function destroy(Menu $menu, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($menu);
        return response()->json(null, 204);
    }
    
    /**
     * Menus bulk destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/menu/menus/bulk_destroy/204.json
     * @responseFile 422 responses/menu/menus/bulk_destroy/422.json
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