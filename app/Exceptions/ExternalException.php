<?php

namespace App\Exceptions;

use Exception;

class ExternalException extends Exception
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
        return response()->json(['message' => $this->message ?? 'Algo não saiu como esperado no servidor external'], $this->code ?? 500);
    }
}
