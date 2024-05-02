<?php

namespace App\Http\Controllers;

use App\Dto\BaseOutput;
use App\Http\Requests\TransferRequest;
use App\Models\Transfer;
use App\Models\Wallet;
use App\Repositories\TransferRepository;
use App\Repositories\WalletRepository;
use App\Services\TransferService;
use App\Services\WalletService;

class TransferController extends Controller
{
    public $service;

    public function __construct(){
        $transferRepository = new TransferRepository(new Transfer());
        $walletRepository = new WalletRepository(new Wallet());
        $walletService = new WalletService($walletRepository);

        $this->service = new TransferService($transferRepository, $walletService);
    }

    public function newTransfer(TransferRequest $request){
        $response = new BaseOutput(
            "Usuário cadastrado com sucesso!",
            $this->service->newTransfer($request)
        );

        return $response->render(200);
    }
}
