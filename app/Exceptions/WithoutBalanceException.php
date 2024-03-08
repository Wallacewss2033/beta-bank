<?php

namespace App\Exceptions;

use Exception;

class WithoutBalanceException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function render()
    {
        return response()->json(['message' => $this->message ?? 'Fundos insuficientes!'], $this->code ?? 422);
    }
}
