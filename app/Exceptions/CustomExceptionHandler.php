<?php

namespace App\Exceptions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Throwable;

class CustomExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof InvalidCategoryException) {
            // セッションにエラーメッセージを保存
            session()->flash('error', $exception->getMessage());

            // 元のページにリダイレクト
            // 例: 前のURLに戻す (back()), あるいは /home 等に変更可能
            return redirect()->back();
        }

        // それ以外の例外は 500エラー扱いにするなど自由に実装
        return response()->view('errors.500', [
            'error' => $exception->getMessage(),
        ], 500);
    }
}
