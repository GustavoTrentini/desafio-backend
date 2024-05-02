<?php

namespace App\Exceptions;

use Exception;

class NotificationException extends Exception
{
    public $message;
    public $error;
    public $code;

    public function __construct($message = 'Erro ao enviar Notificação!', $error = null, $code = 500)
    {
        $this->error = $error;
        $this->message = $message;
        $this->code = $code;
    }

    public function render()
    {
        return response()->json([
            'message' => $this->message,
            'error' => $this->error,
            'code' => $this->code
        ], $this->code);
    }
}
