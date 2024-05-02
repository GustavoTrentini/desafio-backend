<?php

namespace App\Http\Controllers;

use App\Dto\BaseOutput;
use App\Http\Requests\DepositRequest;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use App\Services\WalletService;

class WalletController extends Controller
{
    public $service;

    public function __construct(){
        $walletRepository = new WalletRepository(new Wallet());
        $this->service = new WalletService($walletRepository);
    }

    public function getWallet(){
        $response = new BaseOutput(
            "Carteira consultada com sucesso!",
            $this->service->getWallet()
        );

        return $response->render(200);
    }

    public function deposit(DepositRequest $request){
        $response = new BaseOutput(
            "Valor adicionado com sucesso!",
            $this->service->addToWallet(
                auth()->id(),
                $request->input('value')
            )
        );

        return $response->render(200);
    }
}
