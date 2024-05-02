<?php

namespace App\Repositories;

use App\Dto\Input\MyWalletInput;
use App\Dto\Input\WalletInput;
use App\Models\Wallet;

class WalletRepository
{
    public function __construct(public Wallet $wallet){}

    public function newWallet(WalletInput $walletInput): Wallet{
        return $this->wallet->newWallet($walletInput);
    }

    public function getWallet(MyWalletInput $myWalletInput): Wallet | null{
        return $this->wallet->getWallet($myWalletInput);
    }
}
