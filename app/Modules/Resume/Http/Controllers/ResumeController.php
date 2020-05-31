<?php 

declare( strict_types = 1 );

namespace App\Modules\Resume\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
use App\Modules\Resume\Models\Resume;
use App\Modules\Resume\Http\Requests\Resume\{
    MetaRequest,
	IndexRequest,
	DestroyRequest,
	BulkDestroyRequest,
	ShowRequest
};
use App\Services\Response\FractalManager;
use App\Modules\Resume\Transformers\ResumeTransformer;
use App\Modules\Resume\Services\Crud\ResumeCrudService;
use App\Modules\Resume\Services\Fetch\ResumeFetchService;
use App\Modules\Vacancy\Services\Fetch\VacancyFetchService;


/**
 * @group  RESUME
 */
class ResumeController extends Controller
{
    
    /**
     * @var  FractalManager
     */
    private $fractalManager;
    
    /**
     * @var  ResumeTransformer
     */
    private $transformer;
    
    /**
     * @var  ResumeCrudService
     */
    private $crudService;
    
    /**
     * @var  ResumeFetchService
     */
    private $fetchService;
    
    /**
     * @var  VacancyFetchService
     */
    private $vacancyFetchService;

    /*
    * @param  FractalManager $fractalManager
    * @param  ResumeTransformer $transformer
    * @param  ResumeCrudService $crudService
    * @param  ResumeFetchService $fetchService
    * @param  VacancyFetchService $vacancyFetchService
    */
    public function __construct(   
        FractalManager $fractalManager,    
        ResumeTransformer $transformer,    
        ResumeCrudService $crudService,    
        ResumeFetchService $fetchService,    
        VacancyFetchService $vacancyFetchService         
    ) 
    {    
        $this->fractalManager = $fractalManager;    
        $this->transformer = $transformer;    
        $this->crudService = $crudService;    
        $this->fetchService = $fetchService;    
        $this->vacancyFetchService = $vacancyFetchService;        
    }
    
    /**
     * Resumes meta
     *
     * @authenticated
     * 
     * @responseFile  200 responses/resume/resumes/meta/200.json
     *      
     * @param  MetaRequest $request
     * @return    JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
			'labels' => __('resume::resume'),
			'options' => [
				'vacancies' => ExtArrHelper::valueTextFromList($this->vacancyFetchService->getList()),
			],
		]);
    }

    /**
     * Resumes list
     *
     * @authenticated
     * 
     * @responseFile  200 responses/resume/resumes/index/200.json
     * @responseFile  422 responses/resume/resumes/index/422.json
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
     * Resumes show
     *
     * @authenticated
     * 
     * @responseFile  200 responses/resume/resumes/show/200.json
     * @responseFile  422 responses/resume/resumes/show/404.json
     *      
     * @param      Resume $resume
     * @param      ShowRequest $request
     * @return    JsonResponse
     */
    public function show(Resume $resume, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item($resume, $this->transformer->setItemIncludes())
        );
        return response()->json($data, 200);            
    }
    /**
     * Resumes destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/resume/resumes/destroy/204.json
     * @responseFile  422 responses/resume/resumes/destroy/404.json
     *      
     * @param      Resume $resume
     * @param      DestroyRequest $request
     * @return    JsonResponse
     */
    public function destroy(Resume $resume, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy($resume);
        return response()->json(null, 204);
    }
    
    /**
     * Resumes bulk destroy
     *
     * @authenticated
     * 
     * @responseFile  204 responses/resume/resumes/bulk_destroy/204.json
     * @responseFile  422 responses/resume/resumes/bulk_destroy/422.json
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