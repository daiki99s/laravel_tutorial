<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;

class CustomExceptionHandler
{
    /**
     * 例外をレスポンスに変換
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof InvalidCategoryException) {
            return response()->json([
                'error' => '無効なカテゴリです',
                'message' => $exception->getMessage(),
            ], 400);
        }

        // それ以外の例外は 500 などを返す
        return response()->json([
            'error' => 'サーバーエラー',
            'message' => $exception->getMessage()
        ], 500);
    }
}
