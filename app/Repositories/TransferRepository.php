<?php

namespace App\Repositories;

use App\Dto\Input\TransferInput;
use App\Models\Transfer;

class TransferRepository
{
    public function __construct(public Transfer $transferModel){}

    public function newTransfer(TransferInput $transferInput): Transfer | null{
        return $this->transferModel->newTransfer($transferInput);
    }
}
