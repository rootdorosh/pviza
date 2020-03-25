<?php

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Base\AdminController;
use App\Modules\Auth\Services\AuthService;
use App\Services\Response\FractalManager;

/**
 * @group AUTH
 */
class LogoutController extends AdminController
{
    /*
     * @var AuthService $authService
     */
    private $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    /**
     * Logout
     *
     * @authenticated
     * 
     * @responseFile 204 responses/auth/logout/204.json
     *
     * @return JsonResponse
     */
    public function __invoke() : JsonResponse
    {
        $this->authService->logout(auth()->user());
        
        return response()->json(null, 204);
    }
}
