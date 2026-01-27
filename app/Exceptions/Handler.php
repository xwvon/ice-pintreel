<?php

namespace App\Exceptions;

use App\Libraries\JsonResponse as J;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $path = $request->path();
        if (strpos($path, 'api') !== false && strpos($path, 'paypal-notify') === false) {
            if ($e instanceof ValidationException) {
                return $this->invalidJson($request, $e);
            }

            if ($e instanceof AuthenticationException) {
                return $this->unauthenticated($request, $e);
            }

            if ($e instanceof AuthorizationException) {
                return $this->unauthorizationed($request, $e);
            }

            /**
             * @var J $j
             */
            $j          = app()->j;
            $j->code    = J::CODE_ERROR;
            $j->message = $e->getMessage();
            $j->exception($e);
            $httpCode = 400;
            if ($e instanceof HttpException) {
                $httpCode = $e->getStatusCode();
            }
            return response()->json($j->toArray(), $httpCode);
        }
        return parent::render($request, $e);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        $msg = $exception->validator->errors()->first();
        /**
         * @var J $j
         */
        $j          = app()->j;
        $j->code    = J::CODE_ERROR;
        $j->message = $msg;
        $j->data    = [
            'errors' => $exception->errors(),
        ];
        return response()->json($j, 200, [], JSON_UNESCAPED_UNICODE);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $j          = app()->j;
        $j->message = $exception->getMessage();
        return response()->json($j, 401);
    }

    protected function unauthorizationed($request, AuthorizationException $exception)
    {
        $j          = app()->j;
        $j->message = '没有权限';
        return response()->json($j, 403);
    }

    protected function invalid($request, ValidationException $exception)
    {
        $pathInfo = $request->getPathInfo();
        if (strpos($pathInfo, '/api') === 0) {
            return $this->invalidJson($request, $exception);
        }
        return parent::invalid($request, $exception);
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        /* @var J $j */
        $j = app()->j;
        $j->exception($e);
        return new JsonResponse(
            $j,
            $this->isHttpException($e) ? $e->getStatusCode() : 500,
            $this->isHttpException($e) ? $e->getHeaders() : [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
//        return new JsonResponse(
//            $this->convertExceptionToArray($e),
//            $this->isHttpException($e) ? $e->getStatusCode() : 500,
//            $this->isHttpException($e) ? $e->getHeaders() : [],
//            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
//        );
    }
}
