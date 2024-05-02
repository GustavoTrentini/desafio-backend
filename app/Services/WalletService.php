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

    public function getWallet(int $userId = null): Wallet{

        $wallet = $this->walletRepository->getWallet(
            new MyWalletInput(['user_id' => $userId ?? auth()->user()->id])
        );

        throw_if(!$wallet, new WalletException('Carteira não encontrada!', null, 404));

        return $wallet;
    }

    public function subtractFromWallet(int $payer, float $value){
        $wallet = $this->walletRepository->getWallet(
            new MyWalletInput(['user_id' => $payer])
        );

        throw_if(!$wallet, new WalletException('Carteira não encontrada!', null, 404));
        throw_if($wallet->balance < $value, new WalletException('Saldo insuficiente!', null, 400));

        $wallet->balance -= $value;

        return $wallet->save();
    }

    public function addToWallet(int $payee, float $value){
        $wallet = $this->walletRepository->getWallet(
            new MyWalletInput(['user_id' => $payee])
        );

        throw_if(!$wallet, new WalletException('Carteira não encontrada!', null, 404));

        $wallet->balance += $value;

        return $wallet->save();
    }
}
