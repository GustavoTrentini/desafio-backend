<?php

namespace App\Services;

use App\Dto\Input\MyWalletInput;
use App\Exceptions\WalletException;
use App\Models\Wallet;
use App\Repositories\WalletRepository;

class WalletService
{
    public function __construct(
        public WalletRepository $walletRepository
    ){}

    public function myWallet(): Wallet{

        $wallet = $this->walletRepository->myWallet(
            new MyWalletInput([
                'user_id' => auth()->user()->id
            ])
        );

        throw_if(!$wallet, new WalletException('Carteira não encontrada!', null, 404));

        return $wallet;
    }
}
