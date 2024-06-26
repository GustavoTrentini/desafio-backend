<?php

namespace App\Contracts;

use App\Dto\Input\MyWalletInput;
use App\Dto\Input\WalletInput;
use App\Models\Wallet;

interface WalletInterface
{
    public function newWallet(WalletInput $walletInput): Wallet;

    public function getWallet(MyWalletInput $myWalletInput): Wallet | null;
}
