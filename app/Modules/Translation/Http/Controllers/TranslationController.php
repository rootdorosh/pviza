<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Translation\Models\Translation;
use App\Modules\Translation\Http\Requests\Translation\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	FormRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Translation\Transformers\TranslationTransformer;
use App\Modules\Translation\Services\Crud\TranslationCrudService;
use App\Modules\Translation\Services\Fetch\TranslationFetchService;


/**
 * @group  TRANSLATION
 */
class TranslationController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  TranslationTransformer
     */
    private $transformer;
    
    /**
     * @var  TranslationCrudService
     */
    private $crudService;
    
    /**
     * @var  TranslationFetchService
     */
    private $fetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  TranslationTransformer $transformer
    * @param  TranslationCrudService $crudService
    * @param  TranslationFetchService $fetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        TranslationTransformer $transformer,    
        TranslationCrudService $crudService,    
        TranslationFetchService $fetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;        
    }
    
    /**
     * Translations meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/translation/translations/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('translation::translation'),
		]);
    }

    /**
     * Translations list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/translation/translations/index/200.json
     * @responseFile  422 responses/translation/translations/index/422.json
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
     * Translations store
     *
     * @authenticated
     * 
     * @responseFile  201 responses/translation/translations/store/201.json
     * @responseFile  422 responses/translation/translations/store/422.json
     *      
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        $translation = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($translation, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }
    /**
     * Translations update
     *
     * @authenticated
     * 
     * @responseFile  200 responses/translation/translations/update/200.json
     * @responseFile  422 responses/translation/translations/update/422.json
     * @responseFile  404 responses/translation/translations/update/404.json
     *      
     * @param      Translation $translation
     * @param      FormRequest $request
     * @return    JsonResponse
     */
    public function update(Translation $translation, FormRequest $request): JsonResponse
    {
        $translation = $this->crudService->update($translation, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($translation, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);            
    }

    /**
     * Translations show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/translation/translations/show/200.json
     * @responseFile  422 responses/translation/translations/show/404.json
     *      
     * @param      Translation $translation
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Translation $translation, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($translation, $this->transformer->setItemIncludes())
        );
        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);            
    }
    /**
     * Translations destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/translation/translations/destroy/204.json
     * @responseFile  422 responses/translation/translations/destroy/404.json
     *      
     * @param      Translation $translation
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Translation $translation, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($translation);
        return response()->json(null, 204);
    }
    
    /**
     * Translations bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/translation/translations/bulk_destroy/204.json
     * @responseFile  422 responses/translation/translations/bulk_destroy/422.json
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