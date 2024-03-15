<?php

namespace App\Utils;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ErrorResolve
{
    public function displayError(Exception $exception, string $title = "Bad Request"): JsonResponse
    {
        $code = 400;

        $display = [
            'message' => $exception->getMessage(),
            'title' => $title,
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
        ];

        Log::debug($display);

        if ($exception->getCode() && is_numeric($exception->getCode())) {
            $code = $exception->getCode();
        }

        if (env('APP_DEBUG')) {
            return response()->json($display, $code);
        }

        return response()->json([
            'tile' => $title,
            'message' => $exception->getMessage(),
        ], $code);
    }
}
