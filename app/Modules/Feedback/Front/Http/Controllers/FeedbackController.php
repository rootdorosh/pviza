<?php

namespace App\Modules\Feedback\Front\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Base\FrontController;
use App\Modules\Feedback\Front\Http\Requests\Feedback\FormRequest;
use App\Modules\Feedback\Services\Crud\FeedbackCrudService;

class FeedbackController extends FrontController
{
    /**
     * @var  FeedbackCrudService
     */
    private $crudService;

    /*
    * @param  FeedbackCrudService $crudService
    */
    public function __construct(FeedbackCrudService $crudService)
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
            'content' => t('feedback.form.msg.success.sended'),
        ]);
    }
}
