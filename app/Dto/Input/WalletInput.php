<?php

namespace App\Dto\Input;

use App\Dto\BaseInput;

class WalletInput extends BaseInput
{
    public int $user_id;
    public ?float $balance = 0;
}
