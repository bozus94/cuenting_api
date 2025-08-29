<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

trait CuentingResponse
{
    protected function success(string $code = 'ok', string $message = 'ok', $data = null, int $http = 200, array $meta = []): JsonResponse
    {
        return response()->json([
            "success" => true,
            "code" => $code,
            "message" => $message,
            "data" => $data,
            "meta" => $meta,
        ], $http);
    }

    protected function failure(string $code = 'ok', string $message = 'ok', $errors = null, int $http = 200, array $meta = []): JsonResponse
    {
        return response()->json([
            "success" => true,
            "code" => $code,
            "message" => $message,
            "data" => null,
            "errors" => $errors,
            "meta" => $meta,
        ], $http);
    }
}
