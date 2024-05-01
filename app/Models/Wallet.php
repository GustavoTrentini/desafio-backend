<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\WalletInterface;
use App\Dto\Input\MyWalletInput;
use App\Dto\Input\WalletInput;

class Wallet extends Model implements WalletInterface
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    public function newWallet(WalletInput $walletInput): Wallet
    {
        return $this->create($walletInput->toArray());
    }

    public function myWallet(MyWalletInput $myWalletInput): Wallet | null
    {
        return $this->firstWhere("user_id", $myWalletInput->user_id);
    }
}
