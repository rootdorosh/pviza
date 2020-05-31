<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Http\Requests\Blog\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	FormRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Blog\Transformers\BlogTransformer;
use App\Modules\Blog\Services\Crud\BlogCrudService;
use App\Modules\Blog\Services\Fetch\BlogFetchService;
use App\Modules\Blog\Services\Fetch\CategoryFetchService;


/**
 * @group  BLOG
 */
class BlogController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  BlogTransformer
     */
    private $transformer;
    
    /**
     * @var  BlogCrudService
     */
    private $crudService;
    
    /**
     * @var  BlogFetchService
     */
    private $fetchService;
    
    /**
     * @var  CategoryFetchService
     */
    private $categoryFetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  BlogTransformer $transformer
    * @param  BlogCrudService $crudService
    * @param  BlogFetchService $fetchService
    * @param  CategoryFetchService $categoryFetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        BlogTransformer $transformer,    
        BlogCrudService $crudService,    
        BlogFetchService $fetchService,    
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
     * Blogs meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/blog/blogs/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('blog::blog'),
			'default' => [
				'is_active' => 1,
				'is_home' => 0,
			],
			'options' => [
				'categories' => ExtArrHelper::valueTextFromList($this->categoryFetchService->getList()),
			],
		]);
    }

    /**
     * Blogs list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/blog/blogs/index/200.json
     * @responseFile  422 responses/blog/blogs/index/422.json
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
     * Blogs store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/blog/blogs/store/201.json
     * @responseFile  422 responses/blog/blogs/store/422.json
     *      
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $blog = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($blog, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Blogs update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/blog/blogs/update/200.json
     * @responseFile  422 responses/blog/blogs/update/422.json
     * @responseFile  404 responses/blog/blogs/update/404.json
     *      
     * @param      Blog $blog
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Blog $blog, FormRequest $request): JsonResponse
    {
        $blog = $this->crudService->update($blog, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($blog, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Blogs show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/blog/blogs/show/200.json
     * @responseFile  422 responses/blog/blogs/show/404.json
     *      
     * @param      Blog $blog
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Blog $blog, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($blog, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }
    /**
     * Blogs destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/blog/blogs/destroy/204.json
     * @responseFile  422 responses/blog/blogs/destroy/404.json
     *      
     * @param      Blog $blog
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Blog $blog, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($blog);
        return response()->json(null, 204);
    }
    
    /**
     * Blogs bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/blog/blogs/bulk_destroy/204.json
     * @responseFile  422 responses/blog/blogs/bulk_destroy/422.json
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