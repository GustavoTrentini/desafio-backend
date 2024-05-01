<?php

namespace App\Http\Controllers;

use App\Dto\BaseOutput;
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

    public function myWallet(){
        $response = new BaseOutput(
            "Carteira consultada com sucesso!",
            $this->service->myWallet()
        );

        return $response->render(200);
    }
}
