<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class WalletException extends Exception
{
    public $customMessage;
    public $error;
    public $code;

    public function __construct($message = 'Erro ao cadastrar carteira', $error = null, $code = 500)
    {
        $this->error = $error;
        $this->customMessage = $message;
        $this->code = $code;
    }

    public function render()
    {
        return response()->json([
            'message' => $this->customMessage,
            'error' => $this->error,
            'code' => $this->code
        ], $this->code);
    }
}
