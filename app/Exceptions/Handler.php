<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\RouteParamValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return redirect(route('scms.auth.login'));
        }
        
        if ($exception instanceof WebValidationException) {
            return redirect($exception->redirectTo)
                ->withInput()
                ->withErrors($exception->errors());
        }
        
        if ($exception instanceof ValidationException || $exception instanceof RouteParamValidationException) {
            $errors = $exception->errors();
            $code   = 422;
        }

        if ($exception instanceof AuthenticationException || $exception instanceof AuthorizationException) {
            $code = 401;
        }
                
        if ($exception instanceof UserNotActiveException) {
            $code = 401;
            $message = 'Пользователь не активный';
        }
                
        return response()->json([
            'message' => $message ?? $exception->getMessage(),
            'errors'  => $errors ?? []
        ], $code ?? 404);
    }
}
