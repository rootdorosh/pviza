<?php

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Base\AdminController;
use App\Modules\Auth\Http\Requests\RemindPasswordEmail;
use App\Modules\Auth\Http\Requests\RemindPasswordInput;
use App\Modules\Auth\Services\AuthService;

/**
 * @group AUTH
 */
class RemindPasswordController extends AdminController
{
    /*
     * @var AuthService
     */
    private $authService;
    
    /*
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Remind password - send email
     *
     * @responseFile 204 responses/auth/remind_password/email/204.json
     * @responseFile 422 responses/auth/remind_password/email/422.json
     * 
     * @param RemindPasswordEmail $request
     * @return JsonResponse
     */
    public function email(RemindPasswordEmail $request): JsonResponse
    {
        $this->authService->remindPasswordSendCode($request);
         
        return response()->json(null, 204);
    }

    /**
     * Remind password - set password
     *
     * @responseFile 204 responses/auth/remind_password/input/204.json
     * @responseFile 422 responses/auth/remind_password/input/422.json
     * 
     * @param RemindPasswordInput $request
     * @return JsonResponse
     */
    public function input(RemindPasswordInput $request): JsonResponse
    {
        $this->authService->setPassword($request->code, $request->password);
        
        return response()->json(null, 204); 
    }
}