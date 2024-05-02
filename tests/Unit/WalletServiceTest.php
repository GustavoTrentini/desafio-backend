<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\WalletService;
use App\Repositories\WalletRepository;
use App\Dto\Input\MyWalletInput;
use App\Models\Wallet;
use App\Exceptions\WalletException;
use App\Models\TypeUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WalletServiceTest extends TestCase
{
    use RefreshDatabase;

    private $walletService;
    private $walletRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->walletRepositoryMock = Mockery::mock(WalletRepository::class);
        $this->walletService = new WalletService($this->walletRepositoryMock);
        TypeUser::factory()->create();
    }

    public function testGetWalletSuccess()
    {
        $userId = 1;
        $wallet = new Wallet(['user_id' => $userId, 'balance' => 1000]);

        Auth::shouldReceive('user')->andReturn((object)['id' => $userId]);
        $this->walletRepositoryMock->shouldReceive('getWallet')
            ->withArgs([Mockery::on(function ($arg) use ($userId) {
                return $arg instanceof MyWalletInput && $arg->user_id == $userId;
            })])
            ->andReturn($wallet);

        $result = $this->walletService->getWallet();

        $this->assertInstanceOf(Wallet::class, $result);
        $this->assertEquals(1000, $result->balance);
    }

    public function testGetWalletNotFound()
    {
        $this->expectException(WalletException::class);
        $this->expectExceptionCode(404);

        $userId = 1;
        Auth::shouldReceive('user')->andReturn((object)['id' => $userId]);
        $this->walletRepositoryMock->shouldReceive('getWallet')
            ->andReturn(null);

        $this->walletService->getWallet();
    }

    public function testSubtractFromWalletSuccess()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userId = 1;
        $wallet = new Wallet(['user_id' => $userId, 'balance' => 1000]);
        $subtractValue = 200;

        $this->walletRepositoryMock->shouldReceive('getWallet')
            ->andReturn($wallet);

        $this->walletService->subtractFromWallet($userId, $subtractValue);

        $this->assertEquals(800, $wallet->balance);
    }

    public function testSubtractFromWalletInsufficientFunds()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->expectException(WalletException::class);
        $this->expectExceptionCode(400);

        $userId = 1;
        $wallet = new Wallet(['user_id' => $userId, 'balance' => 100]);
        $subtractValue = 200;

        $this->walletRepositoryMock->shouldReceive('getWallet')
            ->andReturn($wallet);

        $this->walletService->subtractFromWallet($userId, $subtractValue);
    }
}
