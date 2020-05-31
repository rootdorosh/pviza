<?php

namespace App\Modules\Resume\Front\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Base\FrontController;
use App\Modules\Resume\Front\Http\Requests\Resume\FormRequest;
use App\Modules\Resume\Services\Crud\ResumeCrudService;

class ResumeController extends FrontController
{
    /**
     * @var  ResumeCrudService
     */
    private $crudService;

    /*
    * @param  ResumeCrudService $crudService
    */
    public function __construct(ResumeCrudService $crudService) 
    {    
        $this->crudService = $crudService;        
    }
    
    /*
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function send(FormRequest $request): JsonResponse
    {
        $this->crudService->store($request->validated());
        
        return response()->json([
            'content' => t('resume.form.msg.success.sended'),
        ]);
    }
}
