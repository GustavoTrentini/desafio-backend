<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TransferService;
use App\Repositories\TransferRepository;
use App\Http\Requests\TransferRequest;
use App\Models\Transfer;
use App\Services\WalletService;
use App\Exceptions\TransferException;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;

class TransferServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $service;
    private $walletServiceMock;
    private $transferRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->walletServiceMock = $this->createMock(WalletService::class);
        $this->transferRepositoryMock = $this->createMock(TransferRepository::class);
        $this->service = new TransferService($this->transferRepositoryMock, $this->walletServiceMock);
    }

    public function testNewTransferSuccess()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $transferRequest = new TransferRequest([
            'payer' => 1,
            'payee' => 2,
            'value' => 100.00
        ]);
        Auth::shouldReceive('id')->andReturn(1);

        Http::fake([
            env('VALIDATOR_SERVICE_URL') => Http::response(['message' => 'Autorizado'], 200),
        ]);

        $this->walletServiceMock->method('subtractFromWallet')->willReturn(true);
        $this->walletServiceMock->method('addToWallet')->willReturn(true);
        $this->transferRepositoryMock->method('newTransfer')->willReturn(new Transfer);

        $result = $this->service->newTransfer($transferRequest);
        $this->assertInstanceOf(Transfer::class, $result);
    }

    public function testNewTransferUnauthorizedException()
    {
        $transferRequest = new TransferRequest([
            'payer' => 1,
            'payee' => 2,
            'value' => 100.00
        ]);
        Auth::shouldReceive('id')->andReturn(1);

        Http::fake([
            env('VALIDATOR_SERVICE_URL') => Http::response(['message' => 'Não Autorizado'], 200),
        ]);

        $this->expectException(TransferException::class);
        $this->expectExceptionMessage("Transação não autorizada!");

        $this->service->newTransfer($transferRequest);
    }
}
