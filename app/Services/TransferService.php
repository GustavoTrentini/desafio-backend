<?php

namespace App\Services;

use App\Dto\Input\TransferInput;
use App\Dto\Output\ValidatorTransferServiceOutput;
use App\Exceptions\TransferException;
use App\Http\Requests\TransferRequest;
use App\Models\Transfer;
use App\Repositories\TransferRepository;
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

        $payerWallet = $this->walletService->subtractFromWallet(
            $transferInput->payer,
            $transferInput->value
        );

        $payeeWallet = $this->walletService->addToWallet(
            $transferInput->payee,
            $transferInput->value
        );

        throw_if(!$payerWallet || !$payeeWallet, new TransferException("Erro ao atualizar saldos!"));

        $transfer = $this->transferRepository->newTransfer($transferInput);

        if(!$transfer){
            $payeeWallet = $this->walletService->subtractFromWallet(
                $transferInput->payee,
                $transferInput->value
            );

            $payerWallet = $this->walletService->addToWallet(
                $transferInput->payer,
                $transferInput->value
            );

            throw new TransferException("Erro no registro da transferência!");
        }

        return $transfer;
    }

    public function validateTransfer(): ValidatorTransferServiceOutput{
        $response = Http::get(env("VALIDATOR_SERVICE_URL"));

        throw_if(!$response->successful(), new TransferException(
            "Serviço de autorização indisponível!"
        ));

        $response = $response->json();

        $output = new ValidatorTransferServiceOutput(
            $response['message'] ? $response : ["message" => "Não Autorizado"]
        );

        throw_if($output->message != "Autorizado", new TransferException("Transação não autorizada!"));

        return $output;
    }
}
