<?php

namespace App\Contracts;

use App\Dto\Input\MyWalletInput;
use App\Dto\Input\WalletInput;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;

interface WalletInterface
{
    public function newWallet(WalletInput $walletInput): Wallet;

    public function myWallet(MyWalletInput $myWalletInput): Wallet | null;
}
