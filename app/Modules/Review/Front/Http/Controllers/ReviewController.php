<?php

namespace App\Modules\Review\Front\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Base\FrontController;
use App\Modules\Review\Front\Http\Requests\Review\FormRequest;
use App\Modules\Review\Services\Crud\ReviewCrudService;

class ReviewController extends FrontController
{
    /**
     * @var  ReviewCrudService
     */
    private $crudService;

    /*
    * @param  ReviewCrudService $crudService
    */
    public function __construct(ReviewCrudService $crudService)
    {
        $this->crudService = $crudService;
    }

    /*
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function send(FormRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['is_active'] = 0;
        $data['created_at'] = time();
        $this->crudService->store($data);

        return response()->json([
            'content' => t('review.form.msg.success.sended'),
        ]);
    }
}
