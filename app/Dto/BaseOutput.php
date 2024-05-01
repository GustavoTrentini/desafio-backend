<?php

namespace App\Dto;


class BaseOutput
{
    public function __construct(public $msg = "", public $data = null, public $code = 200){}

    public function render()
    {
        return response()->json([
            'message' => $this->msg,
            'status' => $this->code,
            'data' => $this->data
        ], $this->code);
    }
}
