<?php

namespace App\Dto\Input;

use App\Dto\BaseInput;

class TransferInput extends BaseInput
{
    public int $payer;
    public int $payee;
    public float $value;
    public ?string $description = null;
}
