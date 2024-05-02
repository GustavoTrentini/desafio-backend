<?php

namespace App\Contracts;

use App\Dto\Input\TransferInput;
use App\Models\Transfer;

interface TransferInterface
{
    public function newTransfer(TransferInput $transferInput): Transfer | null;
}
