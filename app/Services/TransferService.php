<?php

namespace App\Services;

use App\Dto\Input\TransferInput;
use App\Dto\Output\ValidatorTransferServiceOutput;
use App\Exceptions\TransferException;
use App\Http\Requests\TransferRequest;
use App\Models\Transfer;
use App\Repositories\TransferRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransferService
{
    public function __construct(
        public TransferRepository $transferRepository,
        public WalletService $walletService
    ){}

    public function newTransfer(TransferRequest $transferRequest): Transfer{

        $this->validateTransfer();
        $transferRequest->merge(['payer' => auth()->id()]);
        $transferInput = new TransferInput($transferRequest->all());

        DB::beginTransaction();

        try{
            $this->walletService->subtractFromWallet(
                $transferInput->payer,
                $transferInput->value
            );

            $this->walletService->addToWallet(
                $transferInput->payee,
                $transferInput->value
            );

            $transfer = $this->transferRepository->newTransfer($transferInput);

            DB::commit();

            return $transfer;

        }catch(\Exception $e){
            DB::rollBack();
            throw new TransferException("Erro ao realizar transferência!", $e->getMessage());
        }
    }

    public function validateTransfer(): ValidatorTransferServiceOutput{
        $response = Http::get(env("VALIDATOR_SERVICE_URL"));

        throw_if(!$response->successful(), new TransferException(
            "Serviço de autorização indisponível!"
        ));

        $response = new ValidatorTransferServiceOutput($response->json());

        throw_if(!isset($response->message) || $response->message != "Autorizado",
            new TransferException("Transação não autorizada!")
        );

        return $response;
    }
}
