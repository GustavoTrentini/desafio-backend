<?php

namespace App\Repositories;

use App\Dto\Input\TransferInput;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Collection;

class TransferRepository
{
    public function __construct(public Transfer $transferModel){}

    public function newTransfer(TransferInput $transferInput): Transfer | null{
        return $this->transferModel->newTransfer($transferInput);
    }

    public function send(int $payer): Collection{
        return $this->transferModel->send($payer);
    }

    public function received(int $payee): Collection{
        return $this->transferModel->received($payee);
    }
}
