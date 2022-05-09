<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait ResponseTrait
 * @package App\Traits
 */
trait ResponseTrait
{
    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function responseSuccess($data = [], $message = 'success', $code = 0)
    {
        return response()->json([
            'code'      => $code,
            'message'   => $message,
            'data'      => $data,
        ]);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $httpStatusCode
     * @param int $code
     * @return JsonResponse
     */
    public function responseError($message = 'error', $data = [], $httpStatusCode = 500, $code = 500)
    {
        return response()->json([
            'code'      => $code,
            'message'   => $message,
            'errors'    => $data,
        ], $httpStatusCode);
    }
}
