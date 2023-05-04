<?php

namespace App\Exceptions;

use App\Libraries\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {

            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException || $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return ApiResponse::notFound();
            }

            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return ApiResponse::unauthorized();
            }

            if ($e instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
                return ApiResponse::unauthorized($e->getMessage());
            }

            if ($e instanceof \Illuminate\Routing\Exceptions\InvalidSignatureException) {
                return ApiResponse::unauthorized($e->getMessage());
            }

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return ApiResponse::error($e->getMessage(), $e->validator->getMessageBag()->getMessages(), [], 422);
            }

            // if ($e instanceof \Illuminate\Database\QueryException) {
            //     return ApiResponse::serverError( __('response.server_error'), env('APP_DEBUG', true) === true ? $e->getMessage() : null );
            // }
        });
    }
}