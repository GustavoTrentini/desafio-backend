<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use App\Http\Requests\UserRegisterRequest;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Models\User;
use App\Exceptions\UserException;
use App\Models\TypeUser;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    private $userService;
    private $userRepositoryMock;
    private $walletRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->walletRepositoryMock = Mockery::mock(WalletRepository::class);
        $this->userService = new UserService($this->userRepositoryMock, $this->walletRepositoryMock);
        TypeUser::factory()->create();
    }

    public function testUserRegistrationSuccess()
    {
        $userData = ['email' => 'test@example.com', 'password' => 'password123', 'name' => 'Test User'];
        $request = new UserRegisterRequest($userData);
        $hashedPassword = Hash::make('password123');

        $user = new User($userData);
        $user->id = 1;  // Simulating the user ID set by the database

        $this->userRepositoryMock->shouldReceive('register')
            ->once()
            ->andReturn($user);

        $this->walletRepositoryMock->shouldReceive('newWallet')
            ->once()
            ->andReturn(new Wallet());

        $result = $this->userService->register($request);

        $this->assertInstanceOf(User::class, $result);
        $this->assertTrue(Hash::check('password123', $result->password), 'The password should match the hash.');
    }

    public function testUserRegistrationFailure()
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage("Erro no cadastro de Usuário");

        $userData = ['email' => 'test@example.com', 'password' => 'password123', 'name' => 'Test User'];
        $request = new UserRegisterRequest($userData);

        $this->userRepositoryMock->shouldReceive('register')
            ->once()
            ->andThrow(new \Exception("Database failure"));

        $this->userService->register($request);
    }
}
