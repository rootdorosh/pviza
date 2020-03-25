<?php

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Base\AdminController;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\User\Transformers\UserTransformer;
use App\Modules\Auth\Services\AuthService;
use App\Services\Response\FractalManager;
use App\Base\ScmsHelper;


/**
 * @group AUTH
 */
class LoginController extends AdminController
{
    /*
     * @var AuthService $authService
     */
    private $authService;

    /*
     * var FractalManager
     */
    protected $fractalManager;
    
    /*
     * @param FractalManager $fractalManager
     * @return void
     */
    public function __construct(FractalManager $fractalManager, AuthService $authService)
    {
        $this->fractalManager = $fractalManager;
        $this->authService = $authService;
    }
    
    
    /**
     * Login
     *
     * @responseFile 200 responses/auth/login/200.json
     * @responseFile 422 responses/auth/login/422.json
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request) : JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             
            $token = $this->authService->login(auth()->user());
            
            $data = $this->fractalManager->formatResourceFractal(
                fractal()->item(auth()->user(), (new UserTransformer)->setItemIncludes())
            );
            $data['token'] = $token;
            $data['menu'] = ScmsHelper::getMenu();
            $data['permissions'] = auth()->user()->getPermissions()->pluck('slug');
            
            return response()->json($data);
        } else {
            return response()->json([
                'message' => __('auth::global.given_data_was_invalid'),
                'errors' => ['email' => [__('auth::validation.login_invalid_credentials')]],
            ], 422);
        }
    }
}
