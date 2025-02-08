<?php

namespace App\Exceptions;

use Exception;

class InvalidCategoryException extends Exception
{
    /**
     * コンストラクタ
     * @param string $message カスタムエラーメッセージ（デフォルト設定あり）
     */
    public function __construct($message = 'カテゴリが income と spending の両方に関連付けられています')
    {
        parent::__construct($message);
    }
    
}
