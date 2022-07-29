<?php

namespace App\Http\Controllers\API;

trait ApiResponse
{
    public function success($code, string $message, $data = null, int $httpStatusCode = 200)
    {
        return response()->json([
            'success' => true,
            'code' => $code,
            'message' => $message ? $message : 'success',
            'data' => $data
        ]
        , $httpStatusCode);
      
    }

    public function fail($code, string $message, $data = null, int $httpStatusCode = 400)
    {
        return response()->json([
            'success' => false,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $httpStatusCode);
    }
}
