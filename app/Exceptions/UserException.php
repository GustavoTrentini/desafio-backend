<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UserException extends Exception
{
    public $message;
    public $error;

    public function __construct($message = 'Erro ao cadastrar usuário', $error = null)
    {
        $this->error = $error;
        $this->message = $message;
    }

    public function render()
    {
        $code = match($this->error){
            null => Response::HTTP_BAD_REQUEST,
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        };

        return response()->json([
            'message' => $this->message,
            'error' => $this->error,
            'code' => $code
        ], $code);
    }
}
