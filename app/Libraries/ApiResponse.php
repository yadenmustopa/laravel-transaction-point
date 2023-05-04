<?php
namespace App\Libraries;

/**
 * Summary of ApiResponse
 * @author Yaden Mustopa
 * @copyright (c) 2023
 */
class ApiResponse
{
    protected static $successStatusCode = 200;
    protected static $createdStatusCode = 201;
    protected static $errorStatusCode = 400;
    protected static $unauthorizedStatusCode = 401;
    protected static $forbiddenStatusCode = 403;
    protected static $notFoundStatusCode = 404;
    protected static $conflictStatusCode = 409;
    protected static $unprocessableEntityStatusCode = 422;
    protected static $serverErrorStatusCode = 500;

    /**
     * base
     *
     * @param  mixed $data
     * @param  string $status
     * @param  string $message
     * @param  int $statusCode
     * @return Illuminate\Http\JsonResponse
     */
    private static function base(mixed $data = [], string $status = '', string $message = '', int $statusCode = 200, $headers = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'meta' => [
                'code'    => $statusCode,
                'status'  => $status,
                'message' => $message,
            ],
            'data' => empty($data) ? (object) $data : $data,
        ], $statusCode, $headers, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * @OA\Response(
     *   response="SuccessResponse",
     *   description="Response for success operation",
     *   @OA\JsonContent(
     *      allOf={
     *          @OA\Schema( @OA\Property(property="meta", ref="#/components/schemas/MetaSuccess") ),
     *          @OA\Schema( @OA\Property(property="data", type="object") ),
     *      },
     *   )
     * )
     *
     * @param string $message
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($message = '', $data = [], $headers = [])
    {
        $status  = 'success';
        $message = $message == '' ? __('response.success') : $message;

        return self::base($data, $status, $message, self::$successStatusCode, $headers);
    }

    /**
     * @OA\Response(
     *   response="CreatedResponse",
     *   description="Response for success created operation",
     *   @OA\JsonContent(
     *     allOf={
     *          @OA\Schema( @OA\Property(property="meta", ref="#/components/schemas/MetaSuccess") ),
     *          @OA\Schema( @OA\Property(property="data", type="object") ),
     *      },
     *   )
     * )
     *
     * @param string $message
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function created($message = '', $data = [], $headers = [])
    {
        $status  = 'success';
        $message = $message == '' ? __('response.created.success') : $message;

        return self::base($data, $status, $message, self::$createdStatusCode, $headers);
    }

    /**
     * @OA\Response(
     *   response="ErrorResponse",
     *   description="Response for error operation",
     *   @OA\JsonContent(
     *     allOf={
     *          @OA\Schema( @OA\Property(property="meta", ref="#/components/schemas/MetaError") ),
     *          @OA\Schema( @OA\Property(property="data", type="object") ),
     *      },
     *   )
     * )
     *
     * @param string $message
     * @param array $errors
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = '', $errors = [], $headers = [], $code = null)
    {
        $status  = 'error';
        $message = $message == '' ? __('response.error') : $message;
        $code    = $code ? $code : self::$errorStatusCode;

        return self::base($errors, $status, $message, $code, $headers);
    }

    /**
     * @OA\Response(
     *   response="UnauthorizedResponse",
     *   description="Response for success operation",
     *   @OA\JsonContent(
     *     allOf={
     *          @OA\Schema( @OA\Property(property="meta", ref="#/components/schemas/MetaUnauthorized") ),
     *          @OA\Schema( @OA\Property(property="data", type="object") ),
     *      },
     *   )
     * )
     *
     * @param string $message
     * @param array $errors
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function unauthorized($message = '', $errors = [], $headers = [])
    {
        $status  = 'error';
        $message = $message == '' ? __('response.unauthorized') : $message;

        return self::base($errors, $status, $message, self::$unauthorizedStatusCode, $headers);
    }

    /**
     * @OA\Response(
     *   response="ForbiddenResponse",
     *   description="Response for forbidden operation",
     *   @OA\JsonContent(
     *     allOf={
     *          @OA\Schema( @OA\Property(property="meta", ref="#/components/schemas/MetaForbidden") ),
     *          @OA\Schema( @OA\Property(property="data", type="object") ),
     *      },
     *   )
     * )
     *
     * @param string $message
     * @param array $errors
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function forbidden($message = '', $errors = [], $headers = [])
    {
        $status  = 'error';
        $message = $message == '' ? __('response.forbidden') : $message;

        return self::base($errors, $status, $message, self::$forbiddenStatusCode, $headers);
    }

    /**
     * @OA\Response(
     *   response="NotFoundResponse",
     *   description="Response for not found operation",
     *   @OA\JsonContent(
     *     allOf={
     *          @OA\Schema( @OA\Property(property="meta", ref="#/components/schemas/MetaNotFound") ),
     *          @OA\Schema( @OA\Property(property="data", type="object") ),
     *      },
     *   )
     * )
     *
     * @param string $message
     * @param array $errors
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function notFound($message = '', $errors = [], $headers = [])
    {
        $status  = 'error';
        $message = $message == '' ? __('response.not_found') : $message;

        return self::base($errors, $status, $message, self::$notFoundStatusCode, $headers);
    }

    /**
     * @OA\Response(
     *   response="ConflictResponse",
     *   description="Response for conflict operation",
     *   @OA\JsonContent(
     *     @OA\Property(property="meta", ref="#/components/schemas/MetaConflict"),
     *     @OA\Property(property="data", type="array", @OA\Items()),
     *   )
     * )
     *
     * @param string $message
     * @param array $errors
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function conflict($message = '', $errors = [], $headers = [])
    {
        $status  = 'error';
        $message = $message == '' ? __('response.conflict') : $message;

        return self::base($errors, $status, $message, self::$conflictStatusCode, $headers);
    }

    /**
     * @OA\Response(
     *   response="UnprocessableEntityResponse",
     *   description="Response for unprocessable entity operation",
     *   @OA\JsonContent(
     *     allOf={
     *          @OA\Schema( @OA\Property(property="meta", ref="#/components/schemas/MetaUnprocessableEntity") ),
     *          @OA\Schema( @OA\Property(property="data", type="object") ),
     *      },
     *   )
     * )
     */
    public static function unprocessableEntity($message = '', $errors = [], $headers = [])
    {
        $status  = 'error';
        $message = $message == '' ? __('response.unprocessable_entity') : $message;

        return self::base($errors, $status, $message, self::$unprocessableEntityStatusCode, $headers);
    }

    /**
     * @param string $message
     * @param array $errors
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function serverError($message = '', $errors = [], $headers = [])
    {
        $status  = 'error';
        $message = $message == '' ? __('response.server_error') : $message;

        return self::base($errors, $status, $message, self::$serverErrorStatusCode, $headers);
    }
}