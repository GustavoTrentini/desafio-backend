<?php

namespace App\Contracts;

use App\Dto\Input\MyWalletInput;
use App\Dto\Input\WalletInput;
use App\Models\Wallet;

interface UserInterface
{
    public function newWallet(WalletInput $walletInput): Wallet;

    public function myWallet(MyWalletInput $myWalletInput): Wallet | null;
}
